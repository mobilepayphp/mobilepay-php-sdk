<?php

declare(strict_types=1);

namespace MobilePayPhp\Api\Validation;

use PHPUnit\Framework\TestCase;

/**
 * @covers \MobilePayPhp\Api\Validation\ValidationRule
 *
 * @uses \MobilePayPhp\Api\Validation\ValidationRule
 *
 * @group unit
 */
final class ValidationRuleTest extends TestCase
{
    public function test_can_be_constructed(): void
    {
        self::assertValidationRule(ValidationRule::mandatoryInteger('mandatoryInteger'), 'mandatoryInteger', 'integer', true);
        self::assertValidationRule(ValidationRule::mandatoryString('mandatoryString'), 'mandatoryString', 'string', true);
        self::assertValidationRule(ValidationRule::mandatoryArray('mandatoryArray'), 'mandatoryArray', 'array', true);

        self::assertValidationRule(ValidationRule::optionalInteger('optionalInteger'), 'optionalInteger', 'integer', false);
        self::assertValidationRule(ValidationRule::optionalString('optionalString'), 'optionalString', 'string', false);
        self::assertValidationRule(ValidationRule::optionalArray('optionalArray'), 'optionalArray', 'array', false);
    }

    private static function assertValidationRule(ValidationRule $rule, string $expectedName, string $expectedType, bool $expectedIsMandatory): void
    {
        static::assertSame($expectedName, $rule->getName());
        static::assertSame($expectedType, $rule->getType());
        static::assertSame($expectedIsMandatory, $rule->isMandatory());
    }
}
