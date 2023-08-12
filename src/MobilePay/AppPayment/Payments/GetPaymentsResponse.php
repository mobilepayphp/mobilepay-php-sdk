<?php

declare(strict_types=1);

namespace MobilePayPhp\MobilePay\AppPayment\Payments;

use MobilePayPhp\Api\ResponseInterface;
use MobilePayPhp\Api\Validation\ValidationRule;
use MobilePayPhp\Api\Validation\ValidationTrait;

/**
 * @see GetPaymentsResponseTest
 * @see \MobilePayPhp\MobilePay\AppPayment\Payments\GetPaymentsResponseTest
 */
final class GetPaymentsResponse
{
    use ValidationTrait;

    private readonly int $pageSize;
    private readonly ?int $nextPageNumber;

    /**
     * @var GetPaymentResponse[]
     */
    private readonly array $payments;

    /**
     * @param array<string, int|string> $payload
     */
    public function __construct(array $payload)
    {
        self::validate(
            $payload,
            ValidationRule::mandatoryInteger('pageSize'),
            ValidationRule::optionalInteger('nextPageNumber'),
            ValidationRule::optionalArray('payments')
        );

        $this->pageSize = (int) $payload['pageSize'];
        $this->nextPageNumber = isset($payload['nextPageNumber']) ? (int) $payload['nextPageNumber'] : null;

        $this->payments = array_map(fn (array $payment): \MobilePayPhp\MobilePay\AppPayment\Payments\GetPaymentResponse => new GetPaymentResponse($payment), $payload['payments'] ?? []);
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
     * @return GetPaymentResponse[]
     */
    public function getPayments(): array
    {
        return $this->payments;
    }
}
