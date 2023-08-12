<?php

declare(strict_types=1);

namespace MobilePayPhp\MobilePay\AppPayment\Refunds;

use MobilePayPhp\Api\IsPostTrait;
use MobilePayPhp\Api\RequestInterface;
use MobilePayPhp\MobilePay\AppPayment\Amount;
use MobilePayPhp\MobilePay\Id;

/**
 * @see \MobilePayPhp\MobilePay\AppPayment\Refunds\CreateRefundRequestTest
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
     * @return array{paymentId: string, amount: int, idempotencyKey: string, reference: string, description: string}|null
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
