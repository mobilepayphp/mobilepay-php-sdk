<?php

declare(strict_types=1);

namespace MobilePayPhp\MobilePay\AppPayment\Payments;

use MobilePayPhp\MobilePay\AppPayment\Id;
use PHPUnit\Framework\TestCase;

/**
 * @covers \MobilePayPhp\MobilePay\AppPayment\Payments\ReservePaymentRequest
 *
 * @uses \MobilePayPhp\Api\IsGetTrait
 * @uses \MobilePayPhp\MobilePay\AppPayment\Id
 *
 * @group unit
 */
final class ReservePaymentRequestTest extends TestCase
{
    public function test_can_be_constructed(): void
    {
        $reservePaymentRequest = new ReservePaymentRequest(
            Id::fromString('10F8D908-76CA-4690-9E46-AC2CE61B50B5'),
            Id::fromString('0F05CDF5-DE6C-4375-907F-CCF80806C963'),
            Id::fromString('18947202-3B15-4320-93B5-531ACC863E35')
        );

        static::assertSame('POST', $reservePaymentRequest->getMethod());
        static::assertSame('/v1/integration-test/payments/10f8d908-76ca-4690-9e46-ac2ce61b50b5/reserve', $reservePaymentRequest->getUri());
        static::assertSame(
            [
                'paymentSourceId' => '0f05cdf5-de6c-4375-907f-ccf80806c963',
                'userId' => '18947202-3b15-4320-93b5-531acc863e35',
            ],
            $reservePaymentRequest->getBody()
        );
    }
}
