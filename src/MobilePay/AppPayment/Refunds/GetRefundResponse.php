<?php

declare(strict_types=1);

namespace MobilePayPhp\MobilePay\AppPayment\Refunds;

use MobilePayPhp\Api\ResponseInterface;
use MobilePayPhp\Api\Validation\ValidationRule;
use MobilePayPhp\Api\Validation\ValidationTrait;
use MobilePayPhp\MobilePay\AppPayment\DateTimeFactory;
use MobilePayPhp\MobilePay\Id;

/**
 * @see \MobilePayPhp\MobilePay\AppPayment\Refunds\GetRefundResponseTest
 */
final class GetRefundResponse
{
    use ValidationTrait;

    private readonly int $amount;
    private readonly \DateTimeImmutable $createdOn;
    private readonly string $isoCurrencyCode;
    private readonly Id $merchantId;
    private readonly Id $paymentId;
    private readonly Id $paymentPointId;
    private readonly string $reference;
    private readonly Id $refundId;
    private readonly string $description;

    /**
     * @param array<string, int|string> $payload
     */
    public function __construct(array $payload)
    {
        self::validate(
            $payload,
            ValidationRule::mandatoryInteger('amount'),
            ValidationRule::mandatoryString('createdOn'),
            ValidationRule::mandatoryString('isoCurrencyCode'),
            ValidationRule::mandatoryString('merchantId'),
            ValidationRule::mandatoryString('paymentId'),
            ValidationRule::mandatoryString('paymentPointId'),
            ValidationRule::mandatoryString('reference'),
            ValidationRule::mandatoryString('refundId'),
            ValidationRule::optionalString('description')
        );

        $this->amount = (int) $payload['amount'];

        $this->createdOn = DateTimeFactory::fromString((string) $payload['createdOn']);

        $this->isoCurrencyCode = (string) $payload['isoCurrencyCode'];
        $this->merchantId = Id::fromString((string) $payload['merchantId']);
        $this->paymentId = Id::fromString((string) $payload['paymentId']);
        $this->paymentPointId = Id::fromString((string) $payload['paymentPointId']);
        $this->reference = (string) $payload['reference'];
        $this->refundId = Id::fromString((string) $payload['refundId']);
        $this->description = \array_key_exists('description', $payload) ? (string) $payload['description'] : '';
    }

    public static function fromResponse(ResponseInterface $response): self
    {
        return new self($response->getBody());
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function getCreatedOn(): \DateTimeImmutable
    {
        return $this->createdOn;
    }

    public function getIsoCurrencyCode(): string
    {
        return $this->isoCurrencyCode;
    }

    public function getMerchantId(): Id
    {
        return $this->merchantId;
    }

    public function getRefundId(): Id
    {
        return $this->refundId;
    }

    public function getPaymentId(): Id
    {
        return $this->paymentId;
    }

    public function getPaymentPointId(): Id
    {
        return $this->paymentPointId;
    }

    public function getReference(): string
    {
        return $this->reference;
    }

    public function getDescription(): string
    {
        return $this->description;
    }
}
