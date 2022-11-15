<?php

declare(strict_types=1);

namespace MobilePayPhp\MobilePay\AppPayment\PaymentPoints;

use PHPUnit\Framework\TestCase;

/**
 * @covers \MobilePayPhp\MobilePay\AppPayment\PaymentPoints\GetPaymentPointsRequest
 * @covers \MobilePayPhp\Api\IsGetTrait
 *
 * @uses \MobilePayPhp\MobilePay\AppPayment\Id
 *
 * @group unit
 */
final class GetPaymentPointsRequestTest extends TestCase
{
    /**
     * @dataProvider paginationInfoProvider
     */
    public function test_can_be_constructed(?int $pageNumber, ?int $pageSize, string $queryString): void
    {
        $listPaymentPointRequest = new GetPaymentPointsRequest($pageNumber, $pageSize);

        static::assertSame('GET', $listPaymentPointRequest->getMethod());
        static::assertSame('/v1/paymentpoints'.$queryString, $listPaymentPointRequest->getUri());
        static::assertNull($listPaymentPointRequest->getBody());
    }

    public function paginationInfoProvider(): \Generator
    {
        yield [1, null, '?pageNumber=1'];
        yield [null, 10, '?pageSize=10'];
        yield [1, 10, '?pageNumber=1&pageSize=10'];
        yield [null, null, ''];
    }

    public function test_can_be_constructed_without_pagination_information(): void
    {
        $listPaymentPointRequest = new GetPaymentPointsRequest();

        static::assertSame('GET', $listPaymentPointRequest->getMethod());
        static::assertSame('/v1/paymentpoints', $listPaymentPointRequest->getUri());
        static::assertNull($listPaymentPointRequest->getBody());
    }
}
