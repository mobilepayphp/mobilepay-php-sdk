<?php

declare(strict_types=1);

namespace Jschaedl\MobilePay\AppPayment\Payments;

use Jschaedl\MobilePay\AppPayment\Amount;
use Jschaedl\MobilePay\AppPayment\Id;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Jschaedl\MobilePay\AppPayment\Payments\CreatePaymentRequest
 * @covers \Jschaedl\Api\IsPostTrait
 *
 * @uses \Jschaedl\MobilePay\AppPayment\Amount
 * @uses \Jschaedl\MobilePay\AppPayment\Id
 *
 * @group unit
 */
final class CreatePaymentRequestTest extends TestCase
{
    public function test_can_be_constructed(): void
    {
        $createPaymentRequest = new CreatePaymentRequest(
            Amount::fromFloat(100.00),
            'idempotencyKey',
            Id::fromString('801fc9f2-8f0e-4f5e-bb8e-8a50418dffe7'),
            'redirectUri',
            'reference',
            'description'
        );

        $expectedResponsePayload = [
            'amount' => 10000,
            'idempotencyKey' => 'idempotencyKey',
            'paymentPointId' => '801fc9f2-8f0e-4f5e-bb8e-8a50418dffe7',
            'redirectUri' => 'redirectUri',
            'reference' => 'reference',
            'description' => 'description',
        ];

        static::assertSame('POST', $createPaymentRequest->getMethod());
        static::assertSame('/v1/payments', $createPaymentRequest->getUri());
        static::assertSame($expectedResponsePayload, $createPaymentRequest->getBody());
    }
}
