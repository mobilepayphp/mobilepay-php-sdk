<?php

declare(strict_types=1);

namespace MobilePayPhp\MobilePay\Webhook;

use MobilePayPhp\MobilePay\Webhook\Exception\InvalidArgumentException;

final class Event
{
    private const EVENTS = [
        self::PAYMENT_RESERVED,
        self::PAYMENT_EXPIRED,
        self::PAYMENT_CANCELLED_BY_USER,
        self::PAYMENT_POINT_ACTIVATED,
        self::TRANSFER_SUCCEEDED,
    ];

    private const PAYMENT_RESERVED = 'payment.reserved';
    private const PAYMENT_EXPIRED = 'payment.expired';
    private const PAYMENT_CANCELLED_BY_USER = 'payment.cancelled_by_user';
    private const PAYMENT_POINT_ACTIVATED = 'paymentpoint.activated';
    private const TRANSFER_SUCCEEDED = 'transfer.succeeded';

    private readonly string $event;

    public function __construct(string $event)
    {
        if (!\in_array($event, self::EVENTS, true)) {
            throw new InvalidArgumentException(sprintf('Given event %s does not exist. Possible events are: %s', $event, implode('|', self::EVENTS)));
        }

        $this->event = $event;
    }

    public static function paymentReservedEvent(): self
    {
        return new self(self::PAYMENT_RESERVED);
    }

    public static function paymentExpiredEvent(): self
    {
        return new self(self::PAYMENT_EXPIRED);
    }

    public static function paymentCancelledByUserEvent(): self
    {
        return new self(self::PAYMENT_CANCELLED_BY_USER);
    }

    public static function paymentPointActivatedEvent(): self
    {
        return new self(self::PAYMENT_POINT_ACTIVATED);
    }

    public static function transferSucceededEvent(): self
    {
        return new self(self::TRANSFER_SUCCEEDED);
    }

    public function getEvent(): string
    {
        return $this->event;
    }

    public function isPaymentReserved(): bool
    {
        return self::PAYMENT_RESERVED === $this->event;
    }

    public function isPaymentExpired(): bool
    {
        return self::PAYMENT_EXPIRED === $this->event;
    }

    public function isPaymentCancelledByUser(): bool
    {
        return self::PAYMENT_CANCELLED_BY_USER === $this->event;
    }

    public function isPaymentPaymentPointActivated(): bool
    {
        return self::PAYMENT_POINT_ACTIVATED === $this->event;
    }

    public function isTransferSucceeded(): bool
    {
        return self::TRANSFER_SUCCEEDED === $this->event;
    }
}
