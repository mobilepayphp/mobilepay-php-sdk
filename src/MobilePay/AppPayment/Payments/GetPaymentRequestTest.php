<?php

declare(strict_types=1);

namespace Jschaedl\MobilePay\AppPayment\Payments;

use Jschaedl\MobilePay\AppPayment\Id;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Jschaedl\MobilePay\AppPayment\Payments\GetPaymentRequest
 * @covers \Jschaedl\Api\IsPostTrait
 *
 * @uses \Jschaedl\MobilePay\AppPayment\Id
 *
 * @group unit
 */
final class GetPaymentRequestTest extends TestCase
{
    public function test_can_be_constructed(): void
    {
        $getPaymentRequest = new GetPaymentRequest(Id::fromString('b27a3b36-e0ac-48ca-99f6-ba323111a529'));

        static::assertSame('GET', $getPaymentRequest->getMethod());
        static::assertSame('/v1/payments/b27a3b36-e0ac-48ca-99f6-ba323111a529', $getPaymentRequest->getUri());
        static::assertNull($getPaymentRequest->getBody());
    }
}
