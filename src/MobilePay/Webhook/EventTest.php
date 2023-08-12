<?php

declare(strict_types=1);

namespace MobilePayPhp\MobilePay\Webhook;

use MobilePayPhp\MobilePay\Webhook\Exception\InvalidArgumentException;
use PHPUnit\Framework\TestCase;

/**
 * @covers \MobilePayPhp\MobilePay\Webhook\Event
 *
 * @group unit
 */
final class EventTest extends TestCase
{
    public function test_it_cannot_be_constructed_with_unknown_event(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new Event('test');
    }

    public function test_event(): void
    {
        $paymentReservedEvent = Event::paymentReservedEvent();
        static::assertSame('payment.reserved', $paymentReservedEvent->getEvent());
        static::assertTrue($paymentReservedEvent->isPaymentReserved());
        static::assertFalse($paymentReservedEvent->isPaymentExpired());
        static::assertFalse($paymentReservedEvent->isPaymentCancelledByUser());
        static::assertFalse($paymentReservedEvent->isPaymentPaymentPointActivated());
        static::assertFalse($paymentReservedEvent->isTransferSucceeded());

        $paymentExpiredEvent = Event::paymentExpiredEvent();
        static::assertSame('payment.expired', $paymentExpiredEvent->getEvent());
        static::assertTrue($paymentExpiredEvent->isPaymentExpired());
        static::assertFalse($paymentExpiredEvent->isPaymentReserved());
        static::assertFalse($paymentExpiredEvent->isPaymentCancelledByUser());
        static::assertFalse($paymentExpiredEvent->isPaymentPaymentPointActivated());
        static::assertFalse($paymentExpiredEvent->isTransferSucceeded());

        $paymentCancelledByUserEvent = Event::paymentCancelledByUserEvent();
        static::assertSame('payment.cancelled_by_user', $paymentCancelledByUserEvent->getEvent());
        static::assertTrue($paymentCancelledByUserEvent->isPaymentCancelledByUser());
        static::assertFalse($paymentCancelledByUserEvent->isPaymentExpired());
        static::assertFalse($paymentCancelledByUserEvent->isPaymentReserved());
        static::assertFalse($paymentCancelledByUserEvent->isPaymentPaymentPointActivated());
        static::assertFalse($paymentCancelledByUserEvent->isTransferSucceeded());

        $paymentPointActivatedEvent = Event::paymentPointActivatedEvent();
        static::assertSame('paymentpoint.activated', $paymentPointActivatedEvent->getEvent());
        static::assertTrue($paymentPointActivatedEvent->isPaymentPaymentPointActivated());
        static::assertFalse($paymentPointActivatedEvent->isPaymentCancelledByUser());
        static::assertFalse($paymentPointActivatedEvent->isPaymentExpired());
        static::assertFalse($paymentPointActivatedEvent->isPaymentReserved());
        static::assertFalse($paymentPointActivatedEvent->isTransferSucceeded());

        $transferSucceededEvent = Event::transferSucceededEvent();
        static::assertSame('transfer.succeeded', $transferSucceededEvent->getEvent());
        static::assertTrue($transferSucceededEvent->isTransferSucceeded());
        static::assertFalse($transferSucceededEvent->isPaymentPaymentPointActivated());
        static::assertFalse($transferSucceededEvent->isPaymentCancelledByUser());
        static::assertFalse($transferSucceededEvent->isPaymentExpired());
        static::assertFalse($transferSucceededEvent->isPaymentReserved());
    }
}
