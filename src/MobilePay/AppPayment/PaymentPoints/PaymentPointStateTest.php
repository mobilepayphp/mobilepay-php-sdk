<?php

declare(strict_types=1);

namespace Jschaedl\MobilePay\AppPayment\PaymentPoints;

use Jschaedl\MobilePay\AppPayment\Exception\InvalidArgumentException;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Jschaedl\MobilePay\AppPayment\PaymentPoints\PaymentPointState
 *
 * @group unit
 */
final class PaymentPointStateTest extends TestCase
{
    public function test_can_be_constructed(): void
    {
        static::assertSame('created', (new PaymentPointState('created'))->getState());
        static::assertSame('active', (new PaymentPointState('active'))->getState());
    }

    public function test_payment_points_state_is_correctly_set(): void
    {
        static::assertTrue((new PaymentPointState('created'))->isCreated());
        static::assertFalse((new PaymentPointState('created'))->isActive());

        static::assertTrue((new PaymentPointState('active'))->isActive());
        static::assertFalse((new PaymentPointState('active'))->isCreated());
    }

    /**
     * @dataProvider invalidStateProvider
     */
    public function test_it_should_throw_an_invalid_argument_exception_on_not_supported_state(string $state): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("State $state is not supported. Supported states are: created, active");

        new PaymentPointState($state);
    }

    public function invalidStateProvider(): \Generator
    {
        yield ['blub'];
        yield ['blah'];
    }
}
