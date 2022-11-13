<?php

declare(strict_types=1);

namespace Jschaedl\MobilePay\AppPayment\Payments;

use Jschaedl\Api\ResponseInterface;
use Jschaedl\Api\Validation\ValidationRule;
use Jschaedl\Api\Validation\ValidationTrait;
use Jschaedl\MobilePay\AppPayment\Id;

/**
 * @see \Jschaedl\MobilePay\AppPayment\Payments\CreatePaymentResponseTest
 */
final class CreatePaymentResponse
{
    use ValidationTrait;

    private readonly Id $paymentId;
    private readonly string $mobilePayAppRedirectUri;

    /**
     * @param array<string, int|string> $payload
     */
    public function __construct(array $payload)
    {
        self::validate(
            $payload,
            ValidationRule::mandatoryString('paymentId'),
            ValidationRule::mandatoryString('mobilePayAppRedirectUri')
        );

        $this->paymentId = Id::fromString((string) $payload['paymentId']);
        $this->mobilePayAppRedirectUri = (string) $payload['mobilePayAppRedirectUri'];
    }

    public static function fromResponse(ResponseInterface $response): self
    {
        return new self($response->getBody());
    }

    public function getPaymentId(): Id
    {
        return $this->paymentId;
    }

    public function getMobilePayAppRedirectUri(): string
    {
        return $this->mobilePayAppRedirectUri;
    }
}