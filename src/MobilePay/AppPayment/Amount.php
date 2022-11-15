<?php

declare(strict_types=1);

namespace MobilePayPhp\MobilePay\AppPayment;

/**
 * @see \MobilePayPhp\MobilePay\AppPayment\AmountTest
 */
final class Amount
{
    private function __construct(private readonly int $amountInCent)
    {
    }

    public static function fromFloat(float $amount): self
    {
        $amountInCent = (int) ($amount * 100);

        if ($amountInCent < 1) {
            throw new \InvalidArgumentException('The minimum amount is 1 cent');
        }

        return new self($amountInCent);
    }

    public function getAmountInCent(): int
    {
        return $this->amountInCent;
    }
}
