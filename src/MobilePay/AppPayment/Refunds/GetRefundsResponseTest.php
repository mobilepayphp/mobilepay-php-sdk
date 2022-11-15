<?php

declare(strict_types=1);

namespace MobilePayPhp\MobilePay\AppPayment\Refunds;

use PHPUnit\Framework\TestCase;

/**
 * @covers \MobilePayPhp\MobilePay\AppPayment\Refunds\GetRefundsResponse
 * @covers \MobilePayPhp\MobilePay\AppPayment\Refunds\GetRefundResponse
 *
 * @uses \MobilePayPhp\MobilePay\AppPayment\Id
 * @uses \MobilePayPhp\MobilePay\AppPayment\DateTimeFactory
 * @uses \MobilePayPhp\Api\Validation\ValidationRule
 *
 * @group unit
 */
final class GetRefundsResponseTest extends TestCase
{
    public function test_can_be_constructed(): void
    {
        $response = new GetRefundsResponse([
            'pageSize' => 1,
            'nextPageNumber' => 2,
            'refunds' => [
                [
                    'amount' => 100,
                    'createdOn' => '2021-07-19T12:42:38+0000',
                    'isoCurrencyCode' => 'isoCurrencyCode',
                    'merchantId' => '62bf5f34-4e2f-4dd0-9ecf-6b4cfa457784',
                    'paymentId' => 'b27a3b36-e0ac-48ca-99f6-ba323111a529',
                    'paymentPointId' => '3e789dd1-03cf-40bd-9187-6900ac5ea259',
                    'reference' => 'reference',
                    'refundId' => '84df7745-1f86-4100-879f-8b542c98e839',
                    'description' => 'description',
                ],
            ],
        ]);

        static::assertSame(1, $response->getPageSize());
        static::assertSame(2, $response->getNextPageNumber());
        static::assertCount(1, $response->getRefunds());
        $refund = $response->getRefunds()[0];
        static::assertSame(100, $refund->getAmount());
        static::assertSame('2021-07-19T12:42:38+0000', $refund->getCreatedOn()->format(\DateTimeImmutable::ISO8601));
        static::assertSame('isoCurrencyCode', $refund->getIsoCurrencyCode());
        static::assertSame('62bf5f34-4e2f-4dd0-9ecf-6b4cfa457784', $refund->getMerchantId()->toString());
        static::assertSame('b27a3b36-e0ac-48ca-99f6-ba323111a529', $refund->getPaymentId()->toString());
        static::assertSame('3e789dd1-03cf-40bd-9187-6900ac5ea259', $refund->getPaymentPointId()->toString());
        static::assertSame('reference', $refund->getReference());
        static::assertSame('84df7745-1f86-4100-879f-8b542c98e839', $refund->getRefundId()->toString());
        static::assertSame('description', $refund->getDescription());
    }
}
