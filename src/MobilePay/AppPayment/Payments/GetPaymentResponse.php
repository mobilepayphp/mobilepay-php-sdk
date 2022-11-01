<?php

declare(strict_types=1);

namespace Jschaedl\MobilePay\AppPayment\Payments;

use Jschaedl\Api\ResponseInterface;
use Jschaedl\Api\Validation\ValidationRule;
use Jschaedl\Api\Validation\ValidationTrait;
use Jschaedl\MobilePay\AppPayment\Amount;
use Jschaedl\MobilePay\AppPayment\DateTimeFactory;
use Jschaedl\MobilePay\AppPayment\Id;

/**
 * @see \Jschaedl\MobilePay\AppPayment\Payments\GetPaymentResponseTest
 */
final class GetPaymentResponse
{
    use ValidationTrait;

    private readonly Id $paymentId;
    private readonly int $amount;
    private readonly string $description;
    private readonly Id $paymentPointId;
    private readonly string $reference;
    private readonly string $redirectUri;
    private readonly PaymentState $state;
    private readonly \DateTimeImmutable $initiatedOn;
    private readonly \DateTimeImmutable $lastUpdatedOn;
    private readonly Id $merchantId;
    private readonly string $isoCurrencyCode;
    private readonly string $paymentPointName;

    /**
     * @param array<string, int|string> $payload
     */
    public function __construct(array $payload)
    {
        self::validate(
            $payload,
            ValidationRule::mandatoryString('paymentId'),
            ValidationRule::mandatoryInteger('amount'),
            ValidationRule::mandatoryString('paymentPointId'),
            ValidationRule::mandatoryString('reference'),
            ValidationRule::mandatoryString('redirectUri'),
            ValidationRule::mandatoryString('state'),
            ValidationRule::mandatoryString('initiatedOn'),
            ValidationRule::mandatoryString('lastUpdatedOn'),
            ValidationRule::mandatoryString('merchantId'),
            ValidationRule::mandatoryString('isoCurrencyCode'),
            ValidationRule::mandatoryString('paymentPointName'),
            ValidationRule::optionalString('description')
        );

        $this->paymentId = Id::fromString((string) $payload['paymentId']);
        $this->amount = (int) $payload['amount'];
        $this->paymentPointId = Id::fromString((string) $payload['paymentPointId']);
        $this->reference = (string) $payload['reference'];
        $this->redirectUri = (string) $payload['redirectUri'];
        $this->state = new PaymentState((string) $payload['state']);

        $this->initiatedOn = DateTimeFactory::fromString((string) $payload['initiatedOn']);
        $this->lastUpdatedOn = DateTimeFactory::fromString((string) $payload['lastUpdatedOn']);

        $this->merchantId = Id::fromString((string) $payload['merchantId']);
        $this->isoCurrencyCode = (string) $payload['isoCurrencyCode'];
        $this->paymentPointName = (string) $payload['paymentPointName'];
        $this->description = \array_key_exists('description', $payload) ? (string) $payload['description'] : '';
    }

    public static function fromResponse(ResponseInterface $response): self
    {
        return new self($response->getBody());
    }

    public function isAmountReserved(Amount $reservedAmount): bool
    {
        return $this->state->isReserved() && $reservedAmount->getAmountInCent() === $this->amount;
    }

    public function isAmountCaptured(Amount $capturedAmount): bool
    {
        return $this->state->isCaptured() && $capturedAmount->getAmountInCent() === $this->amount;
    }

    public function getPaymentId(): Id
    {
        return $this->paymentId;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getPaymentPointId(): Id
    {
        return $this->paymentPointId;
    }

    public function getReference(): string
    {
        return $this->reference;
    }

    public function getRedirectUri(): string
    {
        return $this->redirectUri;
    }

    public function getState(): PaymentState
    {
        return $this->state;
    }

    public function getInitiatedOn(): \DateTimeImmutable
    {
        return $this->initiatedOn;
    }

    public function getLastUpdatedOn(): \DateTimeImmutable
    {
        return $this->lastUpdatedOn;
    }

    public function getMerchantId(): Id
    {
        return $this->merchantId;
    }

    public function getIsoCurrencyCode(): string
    {
        return $this->isoCurrencyCode;
    }

    public function getPaymentPointName(): string
    {
        return $this->paymentPointName;
    }
}
