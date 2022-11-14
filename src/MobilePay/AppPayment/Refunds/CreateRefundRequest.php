<?php

declare(strict_types=1);

namespace Jschaedl\MobilePay\AppPayment\Refunds;

use Jschaedl\Api\IsPostTrait;
use Jschaedl\Api\RequestInterface;
use Jschaedl\MobilePay\AppPayment\Amount;
use Jschaedl\MobilePay\AppPayment\Id;

/**
 * @see \Jschaedl\MobilePay\AppPayment\Refunds\CreateRefundRequestTest
 */
final class CreateRefundRequest implements RequestInterface
{
    use IsPostTrait;
    private readonly int $amount;
    private readonly string $description;

    public function __construct(
        private readonly Id $paymentId,
        Amount $amount,
        private readonly Id $idempotencyKey,
        private readonly string $reference,
        string $description = null
    ) {
        $this->amount = $amount->getAmountInCent();
        $this->description = $description ?? '';
    }

    public function getUri(): string
    {
        return '/v1/refunds';
    }

    /**
     * @return array{paymentId: string, amount: int, idempotencyKey: string, reference: string, description: string}
     */
    public function getBody(): ?array
    {
        return [
            'paymentId' => $this->paymentId->toString(),
            'amount' => $this->amount,
            'idempotencyKey' => $this->idempotencyKey->toString(),
            'reference' => $this->reference,
            'description' => $this->description,
        ];
    }
}
