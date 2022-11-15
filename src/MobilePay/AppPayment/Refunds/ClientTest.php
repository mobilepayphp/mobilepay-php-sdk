<?php

declare(strict_types=1);

namespace MobilePayPhp\MobilePay\AppPayment\Refunds;

use MobilePayPhp\MobilePay\AppPayment\Amount;
use MobilePayPhp\MobilePay\AppPayment\ClientTestTrait;
use MobilePayPhp\MobilePay\AppPayment\Id;
use MobilePayPhp\MobilePay\AppPayment\Payments\Client as PaymentsClient;
use MobilePayPhp\MobilePay\AppPayment\Refunds\Client as RefundsClient;
use PHPUnit\Framework\TestCase;

/**
 * @covers \MobilePayPhp\MobilePay\AppPayment\Refunds\Client
 * @covers \MobilePayPhp\Api\Client
 * @covers \MobilePayPhp\Api\IsGetTrait
 * @covers \MobilePayPhp\Api\IsPostTrait
 * @covers \MobilePayPhp\Api\Response
 * @covers \MobilePayPhp\Api\Validation\ValidationRule
 * @covers \MobilePayPhp\Api\Validation\ValidationTrait
 * @covers \MobilePayPhp\MobilePay\AppPayment\Amount
 * @covers \MobilePayPhp\MobilePay\AppPayment\DateTimeFactory
 * @covers \MobilePayPhp\MobilePay\AppPayment\Id
 * @covers \MobilePayPhp\MobilePay\AppPayment\Refunds\CreateRefundRequest
 * @covers \MobilePayPhp\MobilePay\AppPayment\Refunds\CreateRefundResponse
 * @covers \MobilePayPhp\MobilePay\AppPayment\Refunds\GetRefundRequest
 * @covers \MobilePayPhp\MobilePay\AppPayment\Refunds\GetRefundResponse
 * @covers \MobilePayPhp\MobilePay\AppPayment\ResponseHandler
 *
 * @uses \MobilePayPhp\MobilePay\AppPayment\Payments\Client
 * @uses \MobilePayPhp\MobilePay\AppPayment\Payments\CapturePaymentRequest
 * @uses \MobilePayPhp\MobilePay\AppPayment\Payments\CreatePaymentRequest
 * @uses \MobilePayPhp\MobilePay\AppPayment\Payments\CreatePaymentResponse
 * @uses \MobilePayPhp\MobilePay\AppPayment\Payments\GetPaymentRequest
 * @uses \MobilePayPhp\MobilePay\AppPayment\Payments\GetPaymentResponse
 * @uses \MobilePayPhp\MobilePay\AppPayment\Payments\PaymentState
 * @uses \MobilePayPhp\MobilePay\AppPayment\Payments\ReservePaymentRequest
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

        $refundIdempotencyKey = Id::create();

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
