<?php

declare(strict_types=1);

namespace Jschaedl\MobilePay\AppPayment\Payments;

use Jschaedl\MobilePay\AppPayment\Exception\InvalidArgumentException;

/**
 * @see PaymentStateTest
 * @see \Jschaedl\MobilePay\AppPayment\Payments\PaymentStateTest
 */
final class PaymentState
{
    private const STATES = [
        self::INITIATED,
        self::RESERVED,
        self::CAPTURED,
        self::CANCELLED_BY_MERCHANT,
        self::CANCELLED_BY_SYSTEM,
        self::CANCELLED_BY_USER,
    ];

    /** Initial state. */
    private const INITIATED = 'initiated';

    /** MobilePay user approved payment, ready to be captured. */
    private const RESERVED = 'reserved';

    /** Final state, funds will be transferred during next settlement. */
    private const CAPTURED = 'captured';

    /** Payment was cancelled by you. */
    private const CANCELLED_BY_MERCHANT = 'cancelledByMerchant';

    /** No user interactions with payment were made in 5-10 minutes after creation, so our automated job cancelled it. */
    private const CANCELLED_BY_SYSTEM = 'cancelledBySystem';

    /** User cancelled payment inside MobilePay app. */
    private const CANCELLED_BY_USER = 'cancelledByUser';

    private readonly string $state;

    public function __construct(string $state)
    {
        if (!\in_array($state, self::STATES, true)) {
            throw new InvalidArgumentException(sprintf('Given payment state: %s does not exist. Possible states are: %s', $state, implode('|', self::STATES)));
        }

        $this->state = $state;
    }

    public function getState(): string
    {
        return $this->state;
    }

    public function isInitiated(): bool
    {
        return self::INITIATED === $this->state;
    }

    public function isReserved(): bool
    {
        return self::RESERVED === $this->state;
    }

    public function isCaptured(): bool
    {
        return self::CAPTURED === $this->state;
    }

    public function isCancelled(): bool
    {
        return \in_array($this->state, [self::CANCELLED_BY_MERCHANT, self::CANCELLED_BY_SYSTEM, self::CANCELLED_BY_USER], true);
    }
}
