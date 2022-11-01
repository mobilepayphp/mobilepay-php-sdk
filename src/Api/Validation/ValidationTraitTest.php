<?php

declare(strict_types=1);

namespace Jschaedl\Api\Validation;

use Jschaedl\Api\Validation\Exception\InvalidArgumentException;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Jschaedl\Api\Validation\ValidationTrait
 * @covers \Jschaedl\Api\Validation\Exception\InvalidArgumentException
 *
 * @uses \Jschaedl\Api\Validation\ValidationRule
 *
 * @group unit
 */
final class ValidationTraitTest extends TestCase
{
    public function test_validate_does_not_complain(): void
    {
        $this->expectNotToPerformAssertions();

        new TestRequest([
            'paymentId' => 'F5628719-3C28-44F7-965E-7138E5C5870B',
            'amount' => 1234,
        ]);
    }

    public function test_validate_throws_invalid_argument_exception_if_data_has_missing_properties(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('data has missing properties: paymentId, amount');

        new TestRequest([]);
    }

    public function test_validate_throws_invalid_argument_exception_if_empty_data_for_properties(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('empty data for properties: paymentId, amount');

        new TestRequest([
            'paymentId' => '',
            'amount' => null,
        ]);
    }

    public function test_validate_throws_invalid_argument_exception_if_data_does_not_match_correct_type(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('invalid type for properties: paymentId, amount');

        new TestRequest([
            'paymentId' => 100,
            'amount' => '1234',
        ]);
    }
}

final class TestRequest
{
    use ValidationTrait;

    public function __construct(array $requestData)
    {
        self::validate(
            $requestData,
            ValidationRule::mandatoryString('paymentId'),
            ValidationRule::mandatoryInteger('amount')
        );
    }
}
