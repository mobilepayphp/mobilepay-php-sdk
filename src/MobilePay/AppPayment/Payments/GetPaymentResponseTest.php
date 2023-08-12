<?php

declare(strict_types=1);

namespace MobilePayPhp\MobilePay\AppPayment\Payments;

use MobilePayPhp\MobilePay\AppPayment\Amount;
use PHPUnit\Framework\TestCase;

/**
 * @covers \MobilePayPhp\MobilePay\AppPayment\Payments\GetPaymentResponse
 *
 * @uses \MobilePayPhp\Api\Validation\ValidationRule
 * @uses \MobilePayPhp\MobilePay\AppPayment\Payments\PaymentState
 * @uses \MobilePayPhp\MobilePay\AppPayment\Amount
 * @uses \MobilePayPhp\MobilePay\AppPayment\DateTimeFactory
 * @uses \MobilePayPhp\MobilePay\Id
 *
 * @group unit
 */
final class GetPaymentResponseTest extends TestCase
{
    public function test_can_be_constructed(): void
    {
        $response = new GetPaymentResponse([
            'paymentId' => 'dc9a19ab-d4f3-4f77-85e4-663c9bfa7cde',
            'amount' => 1,
            'description' => 'description',
            'paymentPointId' => 'dc9a19ab-d4f3-4f77-85e4-663c9bfa7cde',
            'reference' => 'reference',
            'redirectUri' => 'redirectUri',
            'state' => 'initiated',
            'initiatedOn' => '2021-07-19T12:42:38+0000',
            'lastUpdatedOn' => '2022-07-19T12:42:38+0000',
            'merchantId' => 'dc9a19ab-d4f3-4f77-85e4-663c9bfa7cde',
            'isoCurrencyCode' => 'isoCurrencyCode',
            'paymentPointName' => 'paymentPointName',
        ]);

        static::assertSame('dc9a19ab-d4f3-4f77-85e4-663c9bfa7cde', $response->getPaymentId()->toString());
        static::assertSame(1, $response->getAmount());
        static::assertSame('description', $response->getDescription());
        static::assertSame('dc9a19ab-d4f3-4f77-85e4-663c9bfa7cde', $response->getPaymentPointId()->toString());
        static::assertSame('reference', $response->getReference());
        static::assertSame('redirectUri', $response->getRedirectUri());
        static::assertSame('2021-07-19T12:42:38+0000', $response->getInitiatedOn()->format(\DateTimeImmutable::ISO8601));
        static::assertSame('2022-07-19T12:42:38+0000', $response->getLastUpdatedOn()->format(\DateTimeImmutable::ISO8601));
        static::assertSame('dc9a19ab-d4f3-4f77-85e4-663c9bfa7cde', $response->getMerchantId()->toString());
        static::assertSame('isoCurrencyCode', $response->getIsoCurrencyCode());
        static::assertSame('paymentPointName', $response->getPaymentPointName());
        static::assertSame((new PaymentState('initiated'))->getState(), $response->getState()->getState());
    }

    public function test_is_amount_reserved(): void
    {
        $response = new GetPaymentResponse([
            'paymentId' => 'b27a3b36-e0ac-48ca-99f6-ba323111a529',
            'amount' => 100,
            'description' => 'description',
            'paymentPointId' => '3e789dd1-03cf-40bd-9187-6900ac5ea259',
            'reference' => 'reference',
            'redirectUri' => 'redirectUri',
            'state' => 'reserved',
            'initiatedOn' => '2021-07-19T12:42:38+0000',
            'lastUpdatedOn' => '2021-07-19T12:42:38+0000',
            'merchantId' => '62bf5f34-4e2f-4dd0-9ecf-6b4cfa457784',
            'isoCurrencyCode' => 'isoCurrencyCode',
            'paymentPointName' => 'paymentPointName',
        ]);

        static::assertTrue($response->isAmountReserved(Amount::fromFloat(1.00)));
        static::assertFalse($response->isAmountReserved(Amount::fromFloat(2.00)));
        static::assertFalse($response->isAmountReserved(Amount::fromFloat(10.00)));
    }

    public function test_is_amount_captured(): void
    {
        $response = new GetPaymentResponse([
            'paymentId' => 'b27a3b36-e0ac-48ca-99f6-ba323111a529',
            'amount' => 100,
            'description' => 'description',
            'paymentPointId' => '3e789dd1-03cf-40bd-9187-6900ac5ea259',
            'reference' => 'reference',
            'redirectUri' => 'redirectUri',
            'state' => 'captured',
            'initiatedOn' => '2021-07-19T12:42:38+0000',
            'lastUpdatedOn' => '2021-07-19T12:42:38+0000',
            'merchantId' => '62bf5f34-4e2f-4dd0-9ecf-6b4cfa457784',
            'isoCurrencyCode' => 'isoCurrencyCode',
            'paymentPointName' => 'paymentPointName',
        ]);

        static::assertTrue($response->isAmountCaptured(Amount::fromFloat(1.00)));
        static::assertFalse($response->isAmountCaptured(Amount::fromFloat(2.00)));
        static::assertFalse($response->isAmountCaptured(Amount::fromFloat(10.00)));
    }
}
