<?php

declare(strict_types=1);

namespace Jschaedl\MobilePay\AppPayment;

use PHPUnit\Framework\TestCase;

/**
 * @covers \Jschaedl\MobilePay\AppPayment\PaymentsGateway
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
 * @group integration
 */
final class PaymentsGatewayTest extends TestCase
{
    use GatewayTestTrait;

    public function setUp(): void
    {
        $paymentPointId = (string) getenv('MOBILEPAY_PAYMENTPOINT_ID');
        $this->paymentsGateway = new PaymentsGateway($this->getMobilePayClient(), $paymentPointId);
    }

    public function test_cancelPayment(): void
    {
        $paymentId = $this->createPayment();

        $initiatedPayment = $this->paymentsGateway->getPayment($paymentId);
        static::assertTrue($initiatedPayment->getState()->isInitiated(), 'payment must be in state cancelled');

        $this->paymentsGateway->cancelPayment($paymentId);
        $cancelledPayment = $this->paymentsGateway->getPayment($paymentId);
        static::assertTrue($cancelledPayment->getState()->isCancelled(), 'payment must be in state cancelled');
    }

    public function test_capturePayment(): void
    {
        $paymentId = $this->createPayment();

        $initiatedPayment = $this->paymentsGateway->getPayment($paymentId);
        static::assertTrue($initiatedPayment->getState()->isInitiated());

        $paymentSourceId = Id::fromString((string) getenv('MOBILEPAY_PAYMENT_SOURCE_ID'));
        $userId = Id::fromString((string) getenv('MOBILEPAY_USER_ID'));

        $this->paymentsGateway->reservePayment($paymentId, $paymentSourceId, $userId);
        $reservedPayment = $this->paymentsGateway->getPayment($paymentId);
        static::assertTrue($reservedPayment->getState()->isReserved(), 'payment must be in state reserved');

        $this->paymentsGateway->capturePayment($paymentId, Amount::fromFloat(1.00));
        $capturedPayment = $this->paymentsGateway->getPayment($paymentId);
        static::assertTrue($capturedPayment->getState()->isCaptured(), 'payment must be in state captured');
    }
}
