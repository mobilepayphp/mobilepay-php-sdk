<?php

declare(strict_types=1);

namespace Jschaedl\MobilePay\AppPayment\Payments;

use Jschaedl\MobilePay\AppPayment\Amount;
use Jschaedl\MobilePay\AppPayment\Id;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Jschaedl\MobilePay\AppPayment\Payments\CapturePaymentRequest
 * @covers \Jschaedl\Api\IsPostTrait
 *
 * @uses \Jschaedl\MobilePay\AppPayment\Amount
 * @uses \Jschaedl\MobilePay\AppPayment\Id
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
