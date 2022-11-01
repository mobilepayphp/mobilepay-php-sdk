<?php

declare(strict_types=1);

namespace Jschaedl\MobilePay\AppPayment\Refunds;

use PHPUnit\Framework\TestCase;

/**
 * @covers \Jschaedl\MobilePay\AppPayment\Refunds\GetRefundsRequest
 * @covers \Jschaedl\Api\IsGetTrait
 *
 * @group unit
 */
final class GetRefundsRequestTest extends TestCase
{
    /**
     * @dataProvider paginationInfoProvider
     */
    public function test_can_be_constructed(?int $pageNumber, ?int $pageSize, string $queryString): void
    {
        $request = new GetRefundsRequest($pageNumber, $pageSize);

        static::assertSame('GET', $request->getMethod());
        static::assertSame('/v1/refunds'.$queryString, $request->getUri());
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
        $request = new GetRefundsRequest();

        static::assertSame('GET', $request->getMethod());
        static::assertSame('/v1/refunds', $request->getUri());
        static::assertNull($request->getBody());
    }
}
