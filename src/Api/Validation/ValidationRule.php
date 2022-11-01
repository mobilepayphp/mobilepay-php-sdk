<?php

declare(strict_types=1);

namespace Jschaedl\Api\Validation;

/**
 * @see \Jschaedl\Api\Validation\ValidationRuleTest
 */
final class ValidationRule
{
    private function __construct(private readonly string $name, private readonly string $type, private readonly bool $isMandatory)
    {
    }

    public static function mandatoryString(string $name): self
    {
        return new self($name, 'string', true);
    }

    public static function optionalString(string $name): self
    {
        return new self($name, 'string', false);
    }

    public static function mandatoryInteger(string $name): self
    {
        return new self($name, 'integer', true);
    }

    public static function optionalInteger(string $name): self
    {
        return new self($name, 'integer', false);
    }

    public static function mandatoryArray(string $name): self
    {
        return new self($name, 'array', true);
    }

    public static function optionalArray(string $name): self
    {
        return new self($name, 'array', false);
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function isMandatory(): bool
    {
        return $this->isMandatory;
    }
}
