<?php

declare(strict_types=1);

namespace Jschaedl\MobilePay\AppPayment\PaymentPoints;

use Jschaedl\Api\Response;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Jschaedl\MobilePay\AppPayment\PaymentPoints\GetPaymentPointsResponse
 *
 * @uses \Jschaedl\Api\Response
 * @uses \Jschaedl\Api\Validation\ValidationRule
 * @uses \Jschaedl\MobilePay\AppPayment\Id
 * @uses \Jschaedl\MobilePay\AppPayment\PaymentPoints\GetPaymentPointResponse
 * @uses \Jschaedl\MobilePay\AppPayment\PaymentPoints\PaymentPointState
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
