<?php

declare(strict_types=1);

namespace MobilePayPhp\MobilePay\AppPayment\Payments;

use MobilePayPhp\MobilePay\AppPayment\Amount;
use MobilePayPhp\MobilePay\AppPayment\ClientTestTrait;
use MobilePayPhp\MobilePay\Id;
use PHPUnit\Framework\TestCase;

/**
 * @covers \MobilePayPhp\MobilePay\AppPayment\Payments\Client
 * @covers \MobilePayPhp\Api\Client
 * @covers \MobilePayPhp\Api\RetryClient
 * @covers \MobilePayPhp\Api\IsGetTrait
 * @covers \MobilePayPhp\Api\IsPostTrait
 * @covers \MobilePayPhp\Api\Response
 * @covers \MobilePayPhp\Api\Validation\ValidationRule
 * @covers \MobilePayPhp\Api\Validation\ValidationTrait
 * @covers \MobilePayPhp\MobilePay\AppPayment\Amount
 * @covers \MobilePayPhp\MobilePay\AppPayment\DateTimeFactory
 * @covers \MobilePayPhp\MobilePay\Id
 * @covers \MobilePayPhp\MobilePay\AppPayment\Payments\CancelPaymentRequest
 * @covers \MobilePayPhp\MobilePay\AppPayment\Payments\CapturePaymentRequest
 * @covers \MobilePayPhp\MobilePay\AppPayment\Payments\CreatePaymentRequest
 * @covers \MobilePayPhp\MobilePay\AppPayment\Payments\CreatePaymentResponse
 * @covers \MobilePayPhp\MobilePay\AppPayment\Payments\GetPaymentRequest
 * @covers \MobilePayPhp\MobilePay\AppPayment\Payments\GetPaymentResponse
 * @covers \MobilePayPhp\MobilePay\AppPayment\Payments\PaymentState
 * @covers \MobilePayPhp\MobilePay\AppPayment\Payments\ReservePaymentRequest
 * @covers \MobilePayPhp\MobilePay\ResponseHandler
 *
 * @group e2e
 */
final class ClientTest extends TestCase
{
    use ClientTestTrait;

    public function setUp(): void
    {
        $paymentPointId = (string) getenv('MOBILEPAY_PAYMENTPOINT_ID');
        if ('' === $paymentPointId) {
            static::fail('No paymentPointId is set, check your MOBILEPAY_PAYMENTPOINT_ID env var.');
        }

        $this->paymentsClient = new Client($this->getMobilePayClient(true), $paymentPointId);
    }

    public function test_cancelPayment(): void
    {
        $paymentId = $this->createPayment();

        $initiatedPayment = $this->paymentsClient->getPayment($paymentId);
        static::assertTrue($initiatedPayment->getState()->isInitiated(), 'payment must be in state cancelled');

        $this->paymentsClient->cancelPayment($paymentId);
        $cancelledPayment = $this->paymentsClient->getPayment($paymentId);
        static::assertTrue($cancelledPayment->getState()->isCancelled(), 'payment must be in state cancelled');
    }

    public function test_capturePayment(): void
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

        $this->paymentsClient->reservePayment($paymentId, $paymentSourceId, $userId);
        $reservedPayment = $this->paymentsClient->getPayment($paymentId);
        static::assertTrue($reservedPayment->getState()->isReserved(), 'payment must be in state reserved');

        $this->paymentsClient->capturePayment($paymentId, Amount::fromFloat(1.00));
        $capturedPayment = $this->paymentsClient->getPayment($paymentId);
        static::assertTrue($capturedPayment->getState()->isCaptured(), 'payment must be in state captured');
    }
}
