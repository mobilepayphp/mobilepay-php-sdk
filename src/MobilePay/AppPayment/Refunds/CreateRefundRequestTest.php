<?php

declare(strict_types=1);

namespace Jschaedl\MobilePay\AppPayment\Refunds;

use Jschaedl\MobilePay\AppPayment\Amount;
use Jschaedl\MobilePay\AppPayment\Id;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Jschaedl\MobilePay\AppPayment\Refunds\CreateRefundRequest
 * @covers \Jschaedl\Api\IsPostTrait
 *
 * @uses \Jschaedl\MobilePay\AppPayment\Amount
 * @uses \Jschaedl\MobilePay\AppPayment\Id
 *
 * @group unit
 */
final class CreateRefundRequestTest extends TestCase
{
    public function test_can_be_constructed(): void
    {
        $request = new CreateRefundRequest(
            Id::fromString('98cb60fe-c1a2-4f4f-8c0a-c6ed1e4692a2'),
            Amount::fromFloat(100.00),
            'idempotencyKey',
            'reference',
            'description'
        );

        $expectedPayload = [
            'paymentId' => '98cb60fe-c1a2-4f4f-8c0a-c6ed1e4692a2',
            'amount' => 10000,
            'idempotencyKey' => 'idempotencyKey',
            'reference' => 'reference',
            'description' => 'description',
        ];

        static::assertSame('POST', $request->getMethod());
        static::assertSame('/v1/refunds', $request->getUri());
        static::assertSame($expectedPayload, $request->getBody());
    }
}
