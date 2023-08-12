<?php

declare(strict_types=1);

namespace MobilePayPhp\MobilePay\AppPayment\PaymentPoints;

use MobilePayPhp\Api\ResponseInterface;
use MobilePayPhp\Api\Validation\ValidationRule;
use MobilePayPhp\Api\Validation\ValidationTrait;

/**
 * @see \MobilePayPhp\MobilePay\AppPayment\PaymentPoints\GetPaymentPointsResponseTest
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

        $this->paymentPoints = array_map(fn (array $paymentPoint): GetPaymentPointResponse => new GetPaymentPointResponse($paymentPoint), $payload['paymentPoints'] ?? []);
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
