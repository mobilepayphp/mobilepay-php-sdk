<?php

declare(strict_types=1);

namespace Jschaedl\MobilePay\AppPayment\PaymentPoints;

use Jschaedl\Api\ResponseInterface;
use Jschaedl\Api\Validation\ValidationRule;
use Jschaedl\Api\Validation\ValidationTrait;

/**
 * @see \Jschaedl\MobilePay\AppPayment\PaymentPoints\GetPaymentPointsResponseTest
 */
final class GetPaymentPointsResponse
{
    use ValidationTrait;

    private readonly int $pageSize;
    private readonly ?int $nextPageNumber;

    /**
     * @var GetPaymentPointResponse[]
     */
    private readonly array $paymentPoints;

    public function __construct(array $payload)
    {
        self::validate(
            $payload,
            ValidationRule::mandatoryInteger('pageSize'),
            ValidationRule::optionalInteger('nextPageNumber'),
            ValidationRule::optionalArray('paymentPoints')
        );

        $this->pageSize = (int) $payload['pageSize'];
        $this->nextPageNumber = isset($payload['nextPageNumber']) ? (int) $payload['nextPageNumber'] : null;

        $this->paymentPoints = array_map(fn (array $paymentPoint) => new GetPaymentPointResponse($paymentPoint), $payload['paymentPoints'] ?? []);
    }

    public static function fromResponse(ResponseInterface $response): self
    {
        return new self($response->getBody());
    }

    public function getPageSize(): int
    {
        return $this->pageSize;
    }

    public function getNextPageNumber(): ?int
    {
        return $this->nextPageNumber;
    }

    /**
     * @return GetPaymentPointResponse[]
     */
    public function getPaymentPoints(): array
    {
        return $this->paymentPoints;
    }
}
