<?php

declare(strict_types=1);

namespace Jschaedl\MobilePay\AppPayment\Payments;

use Jschaedl\MobilePay\AppPayment\Amount;
use Jschaedl\MobilePay\AppPayment\ClientTestTrait;
use Jschaedl\MobilePay\AppPayment\Id;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Jschaedl\MobilePay\AppPayment\Payments\Client
 * @covers \Jschaedl\Api\Client
 * @covers \Jschaedl\Api\IsGetTrait
 * @covers \Jschaedl\Api\IsPostTrait
 * @covers \Jschaedl\Api\Response
 * @covers \Jschaedl\Api\Validation\ValidationRule
 * @covers \Jschaedl\Api\Validation\ValidationTrait
 * @covers \Jschaedl\MobilePay\AppPayment\Amount
 * @covers \Jschaedl\MobilePay\AppPayment\DateTimeFactory
 * @covers \Jschaedl\MobilePay\AppPayment\Id
 * @covers \Jschaedl\MobilePay\AppPayment\Payments\CancelPaymentRequest
 * @covers \Jschaedl\MobilePay\AppPayment\Payments\CapturePaymentRequest
 * @covers \Jschaedl\MobilePay\AppPayment\Payments\CreatePaymentRequest
 * @covers \Jschaedl\MobilePay\AppPayment\Payments\CreatePaymentResponse
 * @covers \Jschaedl\MobilePay\AppPayment\Payments\GetPaymentRequest
 * @covers \Jschaedl\MobilePay\AppPayment\Payments\GetPaymentResponse
 * @covers \Jschaedl\MobilePay\AppPayment\Payments\PaymentState
 * @covers \Jschaedl\MobilePay\AppPayment\Payments\ReservePaymentRequest
 * @covers \Jschaedl\MobilePay\AppPayment\ResponseHandler
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

        $this->paymentsClient = new Client($this->getMobilePayClient(), $paymentPointId);
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
