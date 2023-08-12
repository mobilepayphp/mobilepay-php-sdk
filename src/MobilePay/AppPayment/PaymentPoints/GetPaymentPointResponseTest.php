<?php

declare(strict_types=1);

namespace MobilePayPhp\MobilePay\AppPayment\PaymentPoints;

use PHPUnit\Framework\TestCase;

/**
 * @covers \MobilePayPhp\MobilePay\AppPayment\PaymentPoints\GetPaymentPointResponse
 *
 * @uses \MobilePayPhp\Api\Validation\ValidationRule
 * @uses \MobilePayPhp\MobilePay\Id
 * @uses \MobilePayPhp\MobilePay\AppPayment\PaymentPoints\PaymentPointState
 *
 * @group unit
 */
final class GetPaymentPointResponseTest extends TestCase
{
    public function test_can_be_constructed(): void
    {
        $response = new GetPaymentPointResponse([
            'paymentPointId' => '8a725fd2-c085-4279-b726-34f7f2d745e6',
            'paymentPointName' => 'paymentPointName',
            'state' => 'active',
        ]);

        static::assertSame('8a725fd2-c085-4279-b726-34f7f2d745e6', $response->getPaymentPointId()->toString());
        static::assertSame('paymentPointName', $response->getPaymentPointName());
        static::assertSame('active', $response->getState()->getState());
    }
}
