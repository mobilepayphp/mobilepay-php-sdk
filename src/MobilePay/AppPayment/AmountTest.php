<?php

declare(strict_types=1);

namespace Jschaedl\MobilePay\AppPayment;

use PHPUnit\Framework\TestCase;

/**
 * @covers \Jschaedl\MobilePay\AppPayment\Amount
 *
 * @group unit
 */
final class AmountTest extends TestCase
{
    /**
     * @dataProvider invalidAmountProvider
     */
    public function test_minimum_amount_is_one(float $amount): void
    {
        $this->expectException(\InvalidArgumentException::class);

        Amount::fromFloat($amount);
    }

    public function invalidAmountProvider(): \Generator
    {
        yield [0.005];
        yield [0.00];
        yield [-0.5];
        yield [-1.0];
    }

    /**
     * @dataProvider provideAmountValues
     */
    public function test_it_returns_correct_amount_in_cent(float $givenAmountInEuro, int $expectedAmountInCents): void
    {
        static::assertSame($expectedAmountInCents, Amount::fromFloat($givenAmountInEuro)->getAmountInCent());
    }

    public function provideAmountValues(): \Generator
    {
        yield [0.01, 1];
        yield [0.1, 10];
        yield [0.5, 50];
        yield [1.00, 100];
        yield [1.25, 125];
        yield [100.00, 10000];
        yield [125.25, 12525];
    }
}
