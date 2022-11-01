<?php

declare(strict_types=1);

namespace Jschaedl\MobilePay\AppPayment\Refunds;

use Jschaedl\Api\Validation\Exception\InvalidArgumentException;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Jschaedl\MobilePay\AppPayment\Refunds\CreateRefundResponse
 *
 * @uses \Jschaedl\Api\Validation\ValidationRule
 * @uses \Jschaedl\MobilePay\AppPayment\DateTimeFactory
 * @uses \Jschaedl\MobilePay\AppPayment\Id
 *
 * @group unit
 */
final class CreateRefundResponseTest extends TestCase
{
    public function test_can_be_constructed(): void
    {
        $response = new CreateRefundResponse([
            'refundId' => 'd4f66380-48cd-4985-bd45-79084d62010c',
            'paymentId' => 'a86ac19d-710a-4a0a-9a16-446bd044b2c0',
            'amount' => 1,
            'reference' => 'reference',
            'description' => 'description',
            'createdOn' => '2021-07-19T12:42:38+0000',
            'remainingAmount' => 1,
        ]);

        static::assertSame('d4f66380-48cd-4985-bd45-79084d62010c', $response->getRefundId()->toString());
        static::assertSame('a86ac19d-710a-4a0a-9a16-446bd044b2c0', $response->getPaymentId()->toString());
        static::assertSame(1, $response->getAmount());
        static::assertSame('reference', $response->getReference());
        static::assertSame('description', $response->getDescription());
        static::assertSame('2021-07-19T12:42:38+0000', $response->getCreatedOn()->format(\DateTimeImmutable::ISO8601));
        static::assertSame(1, $response->getRemainingAmount());
    }

    /**
     * @dataProvider invalidPayloadProvider
     */
    public function test_it_should_throw_invalid_argument_exception_on_invalid_payload(array $payload, string $expectedExceptionMessage): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage($expectedExceptionMessage);

        new CreateRefundResponse($payload);
    }

    public function invalidPayloadProvider(): \Generator
    {
        yield 'all values missing' => [[], 'data has missing properties: refundId, paymentId, amount, reference, createdOn'];
        yield 'all values null' => [['refundId' => null, 'paymentId' => null, 'amount' => null, 'reference' => null, 'createdOn' => null, 'remainingAmount' => null, 'description' => null], 'empty data for properties: refundId, paymentId, amount, reference, createdOn'];
        yield 'string values empty' => [['refundId' => '', 'paymentId' => '', 'amount' => 1, 'reference' => '', 'createdOn' => '', 'remainingAmount' => 1, 'description' => ''], 'empty data for properties: refundId, paymentId, reference, createdOn'];
    }
}
