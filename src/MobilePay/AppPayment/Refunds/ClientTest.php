<?php

declare(strict_types=1);

namespace Jschaedl\MobilePay\AppPayment\Refunds;

use Jschaedl\MobilePay\AppPayment\Amount;
use Jschaedl\MobilePay\AppPayment\ClientTestTrait;
use Jschaedl\MobilePay\AppPayment\Id;
use Jschaedl\MobilePay\AppPayment\Payments\Client as PaymentsClient;
use Jschaedl\MobilePay\AppPayment\Refunds\Client as RefundsClient;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Jschaedl\MobilePay\AppPayment\Refunds\Client
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
 * @uses \Jschaedl\MobilePay\AppPayment\Payments\Client
 * @uses \Jschaedl\MobilePay\AppPayment\Payments\CapturePaymentRequest
 * @uses \Jschaedl\MobilePay\AppPayment\Payments\CreatePaymentRequest
 * @uses \Jschaedl\MobilePay\AppPayment\Payments\CreatePaymentResponse
 * @uses \Jschaedl\MobilePay\AppPayment\Payments\GetPaymentRequest
 * @uses \Jschaedl\MobilePay\AppPayment\Payments\GetPaymentResponse
 * @uses \Jschaedl\MobilePay\AppPayment\Payments\PaymentState
 * @uses \Jschaedl\MobilePay\AppPayment\Payments\ReservePaymentRequest
 *
 * @group e2e
 */
final class ClientTest extends TestCase
{
    use ClientTestTrait;

    private Client $refundsClient;

    public function setUp(): void
    {
        $paymentPointId = (string) getenv('MOBILEPAY_PAYMENTPOINT_ID');
        if ('' === $paymentPointId) {
            static::fail('No paymentPointId is set, check your MOBILEPAY_PAYMENTPOINT_ID env var.');
        }

        $this->paymentsClient = new PaymentsClient($this->getMobilePayClient(), $paymentPointId);
        $this->refundsClient = new RefundsClient($this->getMobilePayClient());
    }

    public function test_refunds(): void
    {
        $paymentSourceIdString = (string) getenv('MOBILEPAY_PAYMENT_SOURCE_ID');
        if ('' === $paymentSourceIdString) {
            static::fail('No paymentSourceId is set, check your MOBILEPAY_PAYMENT_SOURCE_ID env var.');
        }

        $userIdString = (string) getenv('MOBILEPAY_USER_ID');
        if ('' === $userIdString) {
            static::fail('No userId is set, check your MOBILEPAY_USER_ID env var.');
        }

        $paymentSourceId = Id::fromString($paymentSourceIdString);
        $userId = Id::fromString($userIdString);

        $paymentId = $this->createPayment();

        $initiatedPayment = $this->paymentsClient->getPayment($paymentId);
        static::assertTrue($initiatedPayment->getState()->isInitiated());

        // todo: sometime mobilepay is not fast enough (payment not captured or reserved yet to make refund)
        // todo: sometime mobilepay is not fast enough (409 code: processing_error; message: We were not able to process your request. Please change idempotency key and try again or contact our support.)

        $this->paymentsClient->reservePayment($paymentId, $paymentSourceId, $userId);
        $reservedPayment = $this->paymentsClient->getPayment($paymentId);
        static::assertTrue($reservedPayment->getState()->isReserved());

        $this->paymentsClient->capturePayment($paymentId, Amount::fromFloat(1.00));
        $capturedPayment = $this->paymentsClient->getPayment($paymentId);
        static::assertTrue($capturedPayment->getState()->isCaptured());

        $refundIdempotencyKey = Id::create()->toString();

        $partialRefund = $this->refundsClient->createRefund($paymentId, Amount::fromFloat(0.5), $refundIdempotencyKey, 'reference', 'description');
        static::assertSame($paymentId->toString(), $partialRefund->getPaymentId()->toString());
        static::assertSame(50, $partialRefund->getRemainingAmount());

        $completeRefund = $this->refundsClient->createRefund($paymentId, Amount::fromFloat(0.5), $refundIdempotencyKey, 'reference', 'description');
        static::assertSame($paymentId->toString(), $completeRefund->getPaymentId()->toString());
        static::assertSame(0, $completeRefund->getRemainingAmount());

        $refund = $this->refundsClient->getRefund($completeRefund->getRefundId());
        static::assertSame($paymentId->toString(), $refund->getPaymentId()->toString());
        static::assertSame(50, $refund->getAmount());
    }
}
