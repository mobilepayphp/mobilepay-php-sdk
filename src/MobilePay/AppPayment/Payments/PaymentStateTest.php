<?php

declare(strict_types=1);

namespace MobilePayPhp\MobilePay\AppPayment\Payments;

use MobilePayPhp\MobilePay\AppPayment\Exception\InvalidArgumentException;
use PHPUnit\Framework\TestCase;

/**
 * @covers \MobilePayPhp\MobilePay\AppPayment\Payments\PaymentState
 *
 * @group unit
 */
final class PaymentStateTest extends TestCase
{
    public function test_it_cannot_be_constructed_with_unknown_state(): void
    {
        $this->expectException(InvalidArgumentException::class);

        (new PaymentState('open'))->getState();
    }

    public function test_payment_state_is_correctly_set(): void
    {
        $initiated = new PaymentState('initiated');
        static::assertSame('initiated', $initiated->getState());
        static::assertTrue($initiated->isInitiated());
        static::assertFalse($initiated->isCaptured());
        static::assertFalse($initiated->isReserved());
        static::assertFalse($initiated->isCancelled());

        $reserved = new PaymentState('reserved');
        static::assertSame('reserved', $reserved->getState());
        static::assertTrue($reserved->isReserved());
        static::assertFalse($reserved->isInitiated());
        static::assertFalse($reserved->isCaptured());
        static::assertFalse($reserved->isCancelled());

        $captured = new PaymentState('captured');
        static::assertSame('captured', $captured->getState());
        static::assertTrue($captured->isCaptured());
        static::assertFalse($captured->isReserved());
        static::assertFalse($captured->isInitiated());
        static::assertFalse($captured->isCancelled());

        $cancelledByMerchant = new PaymentState('cancelledByMerchant');
        static::assertSame('cancelledByMerchant', $cancelledByMerchant->getState());
        static::assertTrue($cancelledByMerchant->isCancelled());
        static::assertFalse($cancelledByMerchant->isCaptured());
        static::assertFalse($cancelledByMerchant->isReserved());
        static::assertFalse($cancelledByMerchant->isInitiated());

        $cancelledBySystem = new PaymentState('cancelledBySystem');
        static::assertSame('cancelledBySystem', $cancelledBySystem->getState());
        static::assertTrue($cancelledBySystem->isCancelled());
        static::assertFalse($cancelledBySystem->isCaptured());
        static::assertFalse($cancelledBySystem->isReserved());
        static::assertFalse($cancelledBySystem->isInitiated());

        $cancelledByUser = new PaymentState('cancelledByUser');
        static::assertSame('cancelledByUser', $cancelledByUser->getState());
        static::assertTrue($cancelledByUser->isCancelled());
        static::assertFalse($cancelledByUser->isCaptured());
        static::assertFalse($cancelledByUser->isReserved());
        static::assertFalse($cancelledByUser->isInitiated());
    }
}
