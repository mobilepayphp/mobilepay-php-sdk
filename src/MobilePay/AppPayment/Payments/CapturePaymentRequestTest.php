<?php

declare(strict_types=1);

namespace MobilePayPhp\MobilePay\AppPayment\Payments;

use MobilePayPhp\MobilePay\AppPayment\Amount;
use MobilePayPhp\MobilePay\Id;
use PHPUnit\Framework\TestCase;

/**
 * @covers \MobilePayPhp\MobilePay\AppPayment\Payments\CapturePaymentRequest
 * @covers \MobilePayPhp\Api\IsPostTrait
 *
 * @uses \MobilePayPhp\MobilePay\AppPayment\Amount
 * @uses \MobilePayPhp\MobilePay\Id
 *
 * @group unit
 */
final class CapturePaymentRequestTest extends TestCase
{
    public function test_can_be_constructed(): void
    {
        $capturePaymentRequest = new CapturePaymentRequest(
            Id::fromString('05b79933-4971-4a56-9fa7-be04e94ffd69'),
            Amount::fromFloat(100.00)
        );

        static::assertSame('POST', $capturePaymentRequest->getMethod());
        static::assertSame('/v1/payments/05b79933-4971-4a56-9fa7-be04e94ffd69/capture', $capturePaymentRequest->getUri());
        static::assertSame(['amount' => 10000], $capturePaymentRequest->getBody());
    }
}
