<?php

declare(strict_types=1);

namespace MobilePayPhp\MobilePay\AppPayment\Refunds;

use MobilePayPhp\Api\ResponseInterface;
use MobilePayPhp\Api\Validation\ValidationRule;
use MobilePayPhp\Api\Validation\ValidationTrait;
use MobilePayPhp\MobilePay\AppPayment\DateTimeFactory;
use MobilePayPhp\MobilePay\Id;

/**
 * @see \MobilePayPhp\MobilePay\AppPayment\Refunds\CreateRefundResponseTest
 */
final class CreateRefundResponse
{
    use ValidationTrait;

    private readonly Id $refundId;
    private readonly Id $paymentId;
    private readonly int $amount;
    private readonly string $reference;
    private readonly \DateTimeImmutable $createdOn;
    private readonly int $remainingAmount;
    private readonly string $description;

    /**
     * @param array<string, int|string> $payload
     */
    public function __construct(array $payload)
    {
        self::validate(
            $payload,
            ValidationRule::mandatoryString('refundId'),
            ValidationRule::mandatoryString('paymentId'),
            ValidationRule::mandatoryInteger('amount'),
            ValidationRule::mandatoryString('reference'),
            ValidationRule::mandatoryString('createdOn'),
            ValidationRule::optionalInteger('remainingAmount'),
            ValidationRule::optionalString('description')
        );

        $this->refundId = Id::fromString((string) $payload['refundId']);
        $this->paymentId = Id::fromString((string) $payload['paymentId']);
        $this->amount = (int) $payload['amount'];
        $this->reference = (string) $payload['reference'];

        $this->createdOn = DateTimeFactory::fromString((string) $payload['createdOn']);

        $this->remainingAmount = \array_key_exists('remainingAmount', $payload) ? (int) $payload['remainingAmount'] : 0;
        $this->description = \array_key_exists('description', $payload) ? (string) $payload['description'] : '';
    }

    public static function fromResponse(ResponseInterface $response): self
    {
        return new self($response->getBody());
    }

    public function getRefundId(): Id
    {
        return $this->refundId;
    }

    public function getPaymentId(): Id
    {
        return $this->paymentId;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function getReference(): string
    {
        return $this->reference;
    }

    public function getCreatedOn(): \DateTimeImmutable
    {
        return $this->createdOn;
    }

    public function getRemainingAmount(): int
    {
        return $this->remainingAmount;
    }

    public function getDescription(): string
    {
        return $this->description;
    }
}
