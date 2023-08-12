<?php

declare(strict_types=1);

namespace MobilePayPhp\MobilePay\AppPayment\Refunds;

use MobilePayPhp\Api\ResponseInterface;
use MobilePayPhp\Api\Validation\ValidationRule;
use MobilePayPhp\Api\Validation\ValidationTrait;

/**
 * @see \MobilePayPhp\MobilePay\AppPayment\Refunds\GetRefundsResponseTest
 */
final class GetRefundsResponse
{
    use ValidationTrait;

    private readonly int $pageSize;
    private readonly ?int $nextPageNumber;

    /**
     * @var GetRefundResponse[]
     */
    private readonly array $refunds;

    /**
     * @param array<string, int|string> $payload
     */
    public function __construct(array $payload)
    {
        self::validate(
            $payload,
            ValidationRule::mandatoryInteger('pageSize'),
            ValidationRule::optionalInteger('nextPageNumber'),
            ValidationRule::mandatoryArray('refunds')
        );

        $this->pageSize = (int) $payload['pageSize'];
        $this->nextPageNumber = isset($payload['nextPageNumber']) ? (int) $payload['nextPageNumber'] : null;

        $this->refunds = array_map(fn (array $refund): \MobilePayPhp\MobilePay\AppPayment\Refunds\GetRefundResponse => new GetRefundResponse($refund), $payload['refunds'] ?? []);
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
     * @return GetRefundResponse[]
     */
    public function getRefunds(): array
    {
        return $this->refunds;
    }
}
