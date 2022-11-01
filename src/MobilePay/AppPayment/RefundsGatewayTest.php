<?php

declare(strict_types=1);

namespace Jschaedl\MobilePay\AppPayment;

use PHPUnit\Framework\TestCase;

/**
 * @covers \Jschaedl\MobilePay\AppPayment\RefundsGateway
 * @covers \Jschaedl\Api\Client
 * @covers \Jschaedl\Api\IsGetTrait
 * @covers \Jschaedl\Api\IsPostTrait
 * @covers \Jschaedl\Api\Response
 * @covers \Jschaedl\Api\Validation\ValidationRule
 * @covers \Jschaedl\Api\Validation\ValidationTrait
 * @covers \Jschaedl\MobilePay\AppPayment\Amount
 * @covers \Jschaedl\MobilePay\AppPayment\DateTimeFactory
 * @covers \Jschaedl\MobilePay\AppPayment\Id
 * @covers \Jschaedl\MobilePay\AppPayment\Refunds\CreateRefundRequest
 * @covers \Jschaedl\MobilePay\AppPayment\Refunds\CreateRefundResponse
 * @covers \Jschaedl\MobilePay\AppPayment\Refunds\GetRefundRequest
 * @covers \Jschaedl\MobilePay\AppPayment\Refunds\GetRefundResponse
 * @covers \Jschaedl\MobilePay\AppPayment\ResponseHandler
 *
 * @uses \Jschaedl\MobilePay\AppPayment\PaymentsGateway
 * @uses \Jschaedl\MobilePay\AppPayment\Payments\CapturePaymentRequest
 * @uses \Jschaedl\MobilePay\AppPayment\Payments\CreatePaymentRequest
 * @uses \Jschaedl\MobilePay\AppPayment\Payments\CreatePaymentResponse
 * @uses \Jschaedl\MobilePay\AppPayment\Payments\GetPaymentRequest
 * @uses \Jschaedl\MobilePay\AppPayment\Payments\GetPaymentResponse
 * @uses \Jschaedl\MobilePay\AppPayment\Payments\PaymentState
 * @uses \Jschaedl\MobilePay\AppPayment\Payments\ReservePaymentRequest
 *
 * @group integration
 */
final class RefundsGatewayTest extends TestCase
{
    use GatewayTestTrait;

    private RefundsGateway $refundsGateway;

    public function setUp(): void
    {
        $paymentPointId = (string) getenv('MOBILEPAY_PAYMENTPOINT_ID');
        $this->paymentsGateway = new PaymentsGateway($this->getMobilePayClient(), $paymentPointId);
        $this->refundsGateway = new RefundsGateway($this->getMobilePayClient());
    }

    public function test_refunds(): void
    {
        $paymentId = $this->createPayment();

        $initiatedPayment = $this->paymentsGateway->getPayment($paymentId);
        static::assertTrue($initiatedPayment->getState()->isInitiated());

        // todo: sometime mobilepay is not fast enough (payment not captured or reserved yet to make refund)
        // todo: sometime mobilepay is not fast enough (409 code: processing_error; message: We were not able to process your request. Please change idempotency key and try again or contact our support.)

        // todo: handle paymentSourceId and userId as configuration
        $this->paymentsGateway->reservePayment($paymentId, Id::fromString('e69f44f6-149b-4e09-b80e-e9dc7f079237'), Id::fromString('589d4ae6-e3bb-4c8a-9097-61ae22cdc1d1'));
        $reservedPayment = $this->paymentsGateway->getPayment($paymentId);
        static::assertTrue($reservedPayment->getState()->isReserved());

        $this->paymentsGateway->capturePayment($paymentId, Amount::fromFloat(1.00));
        $capturedPayment = $this->paymentsGateway->getPayment($paymentId);
        static::assertTrue($capturedPayment->getState()->isCaptured());

        $refundIdempotencyKey = Id::create()->toString();

        $partialRefund = $this->refundsGateway->createRefund($paymentId, Amount::fromFloat(0.5), $refundIdempotencyKey, 'reference', 'description');
        static::assertSame($paymentId->toString(), $partialRefund->getPaymentId()->toString());
        static::assertSame(50, $partialRefund->getRemainingAmount());

        $completeRefund = $this->refundsGateway->createRefund($paymentId, Amount::fromFloat(0.5), $refundIdempotencyKey, 'reference', 'description');
        static::assertSame($paymentId->toString(), $completeRefund->getPaymentId()->toString());
        static::assertSame(0, $completeRefund->getRemainingAmount());

        $refund = $this->refundsGateway->getRefund($completeRefund->getRefundId());
        static::assertSame($paymentId->toString(), $refund->getPaymentId()->toString());
        static::assertSame(50, $refund->getAmount());
    }
}
