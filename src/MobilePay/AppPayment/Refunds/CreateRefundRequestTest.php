<?php

declare(strict_types=1);

namespace MobilePayPhp\MobilePay\AppPayment\Refunds;

use MobilePayPhp\MobilePay\AppPayment\Amount;
use MobilePayPhp\MobilePay\Id;
use PHPUnit\Framework\TestCase;

/**
 * @covers \MobilePayPhp\MobilePay\AppPayment\Refunds\CreateRefundRequest
 * @covers \MobilePayPhp\Api\IsPostTrait
 *
 * @uses \MobilePayPhp\MobilePay\AppPayment\Amount
 * @uses \MobilePayPhp\MobilePay\Id
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
            Id::fromString('93c132fc-97a1-41cb-9d65-25d0f3a5d78d'),
            'reference',
            'description'
        );

        $expectedPayload = [
            'paymentId' => '98cb60fe-c1a2-4f4f-8c0a-c6ed1e4692a2',
            'amount' => 10000,
            'idempotencyKey' => '93c132fc-97a1-41cb-9d65-25d0f3a5d78d',
            'reference' => 'reference',
            'description' => 'description',
        ];

        static::assertSame('POST', $request->getMethod());
        static::assertSame('/v1/refunds', $request->getUri());
        static::assertSame($expectedPayload, $request->getBody());
    }
}
