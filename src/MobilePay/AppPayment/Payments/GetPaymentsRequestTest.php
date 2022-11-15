<?php

declare(strict_types=1);

namespace MobilePayPhp\MobilePay\AppPayment\Payments;

use PHPUnit\Framework\TestCase;

/**
 * @covers \MobilePayPhp\MobilePay\AppPayment\Payments\GetPaymentsRequest
 * @covers \MobilePayPhp\Api\IsGetTrait
 *
 * @group unit
 */
final class GetPaymentsRequestTest extends TestCase
{
    /**
     * @dataProvider paginationInfoProvider
     */
    public function test_can_be_constructed(?int $pageNumber, ?int $pageSize, string $queryString): void
    {
        $request = new GetPaymentsRequest($pageNumber, $pageSize);

        static::assertSame('GET', $request->getMethod());
        static::assertSame('/v1/payments'.$queryString, $request->getUri());
        static::assertNull($request->getBody());
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
        $request = new GetPaymentsRequest();

        static::assertSame('GET', $request->getMethod());
        static::assertSame('/v1/payments', $request->getUri());
        static::assertNull($request->getBody());
    }
}
