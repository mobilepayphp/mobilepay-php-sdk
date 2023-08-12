<?php

declare(strict_types=1);

namespace MobilePayPhp\MobilePay;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

/**
 * @see \MobilePayPhp\MobilePay\IdTest
 */
final class Id
{
    private function __construct(
        private readonly UuidInterface $id
    ) {
    }

    public static function create(): self
    {
        return new self(Uuid::uuid4());
    }

    public static function fromString(string $id): self
    {
        return new self(Uuid::fromString($id));
    }

    public function toString(): string
    {
        return $this->id->toString();
    }
}
