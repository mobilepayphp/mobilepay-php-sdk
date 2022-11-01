<?php

declare(strict_types=1);

namespace Jschaedl\MobilePay\AppPayment\PaymentPoints;

use Jschaedl\MobilePay\AppPayment\Exception\InvalidArgumentException;

/**
 * @see \Jschaedl\MobilePay\AppPayment\PaymentPoints\PaymentPointStateTest
 */
final class PaymentPointState
{
    private const CREATED = 'created';
    private const ACTIVE = 'active';

    private readonly string $state;

    public function __construct(string $state)
    {
        if (!\in_array($state, $possibleStates = [self::CREATED, self::ACTIVE], true)) {
            throw new InvalidArgumentException(sprintf('State %s is not supported. Supported states are: %s', $state, implode(', ', $possibleStates)));
        }

        $this->state = $state;
    }

    public function getState(): string
    {
        return $this->state;
    }

    public function isCreated(): bool
    {
        return self::CREATED === $this->state;
    }

    public function isActive(): bool
    {
        return self::ACTIVE === $this->state;
    }
}
