<?php

declare(strict_types=1);

namespace Jschaedl\MobilePay\AppPayment\Refunds;

use Jschaedl\MobilePay\AppPayment\Id;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Jschaedl\MobilePay\AppPayment\Refunds\GetRefundRequest
 * @covers \Jschaedl\Api\IsGetTrait
 *
 * @uses \Jschaedl\MobilePay\AppPayment\Id
 *
 * @group unit
 */
final class GetRefundRequestTest extends TestCase
{
    public function test_can_be_constructed(): void
    {
        $request = new GetRefundRequest(Id::fromString('05b79933-4971-4a56-9fa7-be04e94ffd69'));

        static::assertSame('GET', $request->getMethod());
        static::assertSame('/v1/refunds/05b79933-4971-4a56-9fa7-be04e94ffd69', $request->getUri());
        static::assertNull($request->getBody());
    }
}
