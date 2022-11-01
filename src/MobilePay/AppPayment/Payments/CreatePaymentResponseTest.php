<?php

declare(strict_types=1);

namespace Jschaedl\MobilePay\AppPayment\Payments;

use PHPUnit\Framework\TestCase;

/**
 * @covers \Jschaedl\MobilePay\AppPayment\Payments\CreatePaymentResponse
 *
 * @uses \Jschaedl\Api\Validation\ValidationRule
 * @uses \Jschaedl\MobilePay\AppPayment\Id
 *
 * @group unit
 */
final class CreatePaymentResponseTest extends TestCase
{
    public function test_can_be_constructed(): void
    {
        $response = new CreatePaymentResponse([
            'paymentId' => '3e79d2d8-72e9-47e3-b2ee-23932186f438',
            'mobilePayAppRedirectUri' => 'myapp://relative',
        ]);

        static::assertSame('3e79d2d8-72e9-47e3-b2ee-23932186f438', $response->getPaymentId()->toString());
        static::assertSame('myapp://relative', $response->getMobilePayAppRedirectUri());
    }
}
