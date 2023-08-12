<?php

declare(strict_types=1);

namespace MobilePayPhp\MobilePay\AppPayment\Refunds;

use MobilePayPhp\Api\Validation\Exception\InvalidArgumentException;
use PHPUnit\Framework\TestCase;

/**
 * @covers \MobilePayPhp\MobilePay\AppPayment\Refunds\GetRefundResponse
 *
 * @uses \MobilePayPhp\Api\Validation\ValidationRule
 * @uses \MobilePayPhp\MobilePay\AppPayment\DateTimeFactory
 * @uses \MobilePayPhp\MobilePay\Id
 *
 * @group unit
 */
final class GetRefundResponseTest extends TestCase
{
    public function test_can_be_constructed(): void
    {
        $response = new GetRefundResponse([
            'amount' => 100,
            'createdOn' => '2021-07-19T12:42:38+0000',
            'isoCurrencyCode' => 'isoCurrencyCode',
            'merchantId' => '62bf5f34-4e2f-4dd0-9ecf-6b4cfa457784',
            'paymentId' => 'b27a3b36-e0ac-48ca-99f6-ba323111a529',
            'paymentPointId' => '3e789dd1-03cf-40bd-9187-6900ac5ea259',
            'reference' => 'reference',
            'refundId' => '84df7745-1f86-4100-879f-8b542c98e839',
            'description' => 'description',
        ]);

        static::assertSame(100, $response->getAmount());
        static::assertSame('2021-07-19T12:42:38+0000', $response->getCreatedOn()->format(\DateTimeImmutable::ISO8601));
        static::assertSame('isoCurrencyCode', $response->getIsoCurrencyCode());
        static::assertSame('62bf5f34-4e2f-4dd0-9ecf-6b4cfa457784', $response->getMerchantId()->toString());
        static::assertSame('b27a3b36-e0ac-48ca-99f6-ba323111a529', $response->getPaymentId()->toString());
        static::assertSame('3e789dd1-03cf-40bd-9187-6900ac5ea259', $response->getPaymentPointId()->toString());
        static::assertSame('reference', $response->getReference());
        static::assertSame('84df7745-1f86-4100-879f-8b542c98e839', $response->getRefundId()->toString());
        static::assertSame('description', $response->getDescription());
    }

    /**
     * @dataProvider invalidPayloadProvider
     *
     * @param mixed[]|array<string, null>|array<string, int>|array<string, string> $payload
     */
    public function test_it_should_throw_invalid_argument_exception_on_invalid_payload(array $payload, string $expectedExceptionMessage): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage($expectedExceptionMessage);

        new GetRefundResponse($payload);
    }

    public function invalidPayloadProvider(): \Generator
    {
        yield 'all values missing' => [[], 'data has missing properties: amount, createdOn, isoCurrencyCode, merchantId, paymentId, paymentPointId, reference, refundId'];
        yield 'all values null' => [['amount' => null, 'createdOn' => null, 'isoCurrencyCode' => null, 'merchantId' => null, 'paymentId' => null, 'paymentPointId' => null, 'reference' => null, 'refundId' => null], 'empty data for properties: amount, createdOn, isoCurrencyCode, merchantId, paymentId, paymentPointId, reference, refundId'];
        yield 'string values empty' => [['amount' => 1, 'createdOn' => '', 'isoCurrencyCode' => '', 'merchantId' => '', 'paymentId' => '', 'paymentPointId' => '', 'reference' => '', 'refundId' => ''], 'empty data for properties: createdOn, isoCurrencyCode, merchantId, paymentId, paymentPointId, reference, refundId'];
    }
}
