<?php

declare(strict_types=1);

namespace Jschaedl\MobilePay\AppPayment\Refunds;

use Jschaedl\Api\ResponseInterface;
use Jschaedl\Api\Validation\ValidationRule;
use Jschaedl\Api\Validation\ValidationTrait;

/**
 * @see \Jschaedl\MobilePay\AppPayment\Refunds\GetRefundsResponseTest
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

        $this->refunds = array_map(fn (array $refund) => new GetRefundResponse($refund), $payload['refunds'] ?? []);
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
