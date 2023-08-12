<?php

declare(strict_types=1);

namespace MobilePayPhp\MobilePay\AppPayment\Payments;

use PHPUnit\Framework\TestCase;

/**
 * @covers \MobilePayPhp\MobilePay\AppPayment\Payments\GetPaymentsResponse
 * @covers \MobilePayPhp\MobilePay\AppPayment\Payments\GetPaymentResponse
 *
 * @uses \MobilePayPhp\MobilePay\Id
 * @uses \MobilePayPhp\MobilePay\AppPayment\DateTimeFactory
 * @uses \MobilePayPhp\MobilePay\AppPayment\Payments\PaymentState
 * @uses \MobilePayPhp\Api\Validation\ValidationRule
 *
 * @group unit
 */
final class GetPaymentsResponseTest extends TestCase
{
    public function test_can_be_constructed(): void
    {
        $response = new GetPaymentsResponse([
            'pageSize' => 1,
            'nextPageNumber' => 2,
            'payments' => [
                [
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
                ],
            ],
        ]);

        static::assertSame(1, $response->getPageSize());
        static::assertSame(2, $response->getNextPageNumber());
        static::assertCount(1, $response->getPayments());
        $payment = $response->getPayments()[0];
        static::assertSame('dc9a19ab-d4f3-4f77-85e4-663c9bfa7cde', $payment->getPaymentId()->toString());
        static::assertSame(1, $payment->getAmount());
        static::assertSame('description', $payment->getDescription());
        static::assertSame('dc9a19ab-d4f3-4f77-85e4-663c9bfa7cde', $payment->getPaymentPointId()->toString());
        static::assertSame('reference', $payment->getReference());
        static::assertSame('redirectUri', $payment->getRedirectUri());
        static::assertSame('2021-07-19T12:42:38+0000', $payment->getInitiatedOn()->format(\DateTimeImmutable::ISO8601));
        static::assertSame('2022-07-19T12:42:38+0000', $payment->getLastUpdatedOn()->format(\DateTimeImmutable::ISO8601));
        static::assertSame('dc9a19ab-d4f3-4f77-85e4-663c9bfa7cde', $payment->getMerchantId()->toString());
        static::assertSame('isoCurrencyCode', $payment->getIsoCurrencyCode());
        static::assertSame('paymentPointName', $payment->getPaymentPointName());
        static::assertSame((new PaymentState('initiated'))->getState(), $payment->getState()->getState());
    }
}
