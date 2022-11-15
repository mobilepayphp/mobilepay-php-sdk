<?php

declare(strict_types=1);

namespace MobilePayPhp\MobilePay\AppPayment\PaymentPoints;

use MobilePayPhp\Api\Response;
use PHPUnit\Framework\TestCase;

/**
 * @covers \MobilePayPhp\MobilePay\AppPayment\PaymentPoints\GetPaymentPointsResponse
 *
 * @uses \MobilePayPhp\Api\Response
 * @uses \MobilePayPhp\Api\Validation\ValidationRule
 * @uses \MobilePayPhp\MobilePay\AppPayment\Id
 * @uses \MobilePayPhp\MobilePay\AppPayment\PaymentPoints\GetPaymentPointResponse
 * @uses \MobilePayPhp\MobilePay\AppPayment\PaymentPoints\PaymentPointState
 *
 * @group unit
 */
final class GetPaymentPointsResponseTest extends TestCase
{
    public function test_can_be_constructed(): void
    {
        $response = GetPaymentPointsResponse::fromResponse(
            new Response(200, [
                'pageSize' => 1,
                'nextPageNumber' => 2,
                'paymentPoints' => [
                    [
                        'paymentPointId' => '8a725fd2-c085-4279-b726-34f7f2d745e6',
                        'paymentPointName' => 'paymentPointName',
                        'state' => 'active',
                    ],
                ],
            ])
        );

        static::assertSame(1, $response->getPageSize());
        static::assertSame(2, $response->getNextPageNumber());
        static::assertCount(1, $response->getPaymentPoints());
        static::assertSame('8a725fd2-c085-4279-b726-34f7f2d745e6', $response->getPaymentPoints()[0]->getPaymentPointId()->toString());
        static::assertSame('paymentPointName', $response->getPaymentPoints()[0]->getPaymentPointName());
        static::assertSame('active', $response->getPaymentPoints()[0]->getState()->getState());
    }
}
