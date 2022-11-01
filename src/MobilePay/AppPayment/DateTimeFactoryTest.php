<?php

declare(strict_types=1);

namespace Jschaedl\MobilePay\AppPayment;

use Jschaedl\MobilePay\AppPayment\Exception\InvalidArgumentException;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Jschaedl\MobilePay\AppPayment\DateTimeFactory
 *
 * @group unit
 */
final class DateTimeFactoryTest extends TestCase
{
    public function test_it_creates_a_date_time_immutable_based_on_mobile_pay_date_time_format(): void
    {
        static::assertSame('2021-07-19T12:42:38+0000', DateTimeFactory::fromString('2021-07-19T12:42:38+0000')->format(\DateTimeImmutable::ISO8601));
        static::assertSame('2021-07-19T12:42:38+0000', DateTimeFactory::fromString('2021-07-19T12:42:38+00:00')->format(\DateTimeImmutable::ISO8601));
        static::assertSame('2021-07-19T12:42:38+0000', DateTimeFactory::fromString('2021-07-19T12:42:38Z')->format(\DateTimeImmutable::ISO8601));
    }

    public function test_it_should_throw_an__invalid_argument_exception_on_wrong_date_time_format(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Given datetime string has wrong format. Please use "\DateTimeImmutable::ISO8601"');

        DateTimeFactory::fromString('2021-07-19');
    }
}
