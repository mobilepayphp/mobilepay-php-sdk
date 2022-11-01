<?php

declare(strict_types=1);

namespace Jschaedl\MobilePay\AppPayment\Payments;

use Jschaedl\MobilePay\AppPayment\Id;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Jschaedl\MobilePay\AppPayment\Payments\CancelPaymentRequest
 * @covers \Jschaedl\Api\IsPostTrait
 *
 * @uses \Jschaedl\MobilePay\AppPayment\Id
 *
 * @group unit
 */
final class CancelPaymentRequestTest extends TestCase
{
    public function test_can_be_constructed_without_idempotency_key(): void
    {
        $cancelPaymentRequest = new CancelPaymentRequest(Id::fromString('05b79933-4971-4a56-9fa7-be04e94ffd69'));

        static::assertSame('POST', $cancelPaymentRequest->getMethod());
        static::assertSame('/v1/payments/05b79933-4971-4a56-9fa7-be04e94ffd69/cancel', $cancelPaymentRequest->getUri());
        static::assertNull($cancelPaymentRequest->getBody());
    }

    public function test_can_be_constructed_with_idempotency_key(): void
    {
        $cancelPaymentRequest = new CancelPaymentRequest(
            Id::fromString('05b79933-4971-4a56-9fa7-be04e94ffd69'),
            'idempotencyKey'
        );

        static::assertSame('POST', $cancelPaymentRequest->getMethod());
        static::assertSame('/v1/payments/05b79933-4971-4a56-9fa7-be04e94ffd69/cancel', $cancelPaymentRequest->getUri());

        $actualBody = $cancelPaymentRequest->getBody();
        static::assertArrayHasKey('idempotencyKey', $actualBody);
        static::assertSame('idempotencyKey', $cancelPaymentRequest->getBody()['idempotencyKey']);
    }
}
