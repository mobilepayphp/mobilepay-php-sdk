<?php

declare(strict_types=1);

namespace MobilePayPhp\MobilePay\AppPayment\Payments;

use MobilePayPhp\MobilePay\Id;
use PHPUnit\Framework\TestCase;

/**
 * @covers \MobilePayPhp\MobilePay\AppPayment\Payments\GetPaymentRequest
 * @covers \MobilePayPhp\Api\IsPostTrait
 *
 * @uses \MobilePayPhp\MobilePay\Id
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
