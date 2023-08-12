<?php

declare(strict_types=1);

namespace MobilePayPhp\MobilePay\AppPayment\Payments;

use MobilePayPhp\Api\IsPostTrait;
use MobilePayPhp\Api\RequestInterface;
use MobilePayPhp\MobilePay\AppPayment\Amount;
use MobilePayPhp\MobilePay\Id;

/**
 * @see \MobilePayPhp\MobilePay\AppPayment\Payments\CreatePaymentRequestTest
 */
final class CreatePaymentRequest implements RequestInterface
{
    use IsPostTrait;

    private readonly int $amount;
    private readonly string $description;

    public function __construct(
        Amount $amount,
        private readonly Id $idempotencyKey,
        private readonly Id $paymentPointId,
        private readonly string $redirectUri,
        private readonly string $reference,
        string $description = null
    ) {
        $this->amount = $amount->getAmountInCent();
        $this->description = $description ?? '';
    }

    public function getUri(): string
    {
        return '/v1/payments';
    }

    /**
     * @return array{amount: int, idempotencyKey: string, paymentPointId: string, redirectUri: string, reference: string, description: string}|null
     */
    public function getBody(): ?array
    {
        return [
            'amount' => $this->amount,
            'idempotencyKey' => $this->idempotencyKey->toString(),
            'paymentPointId' => $this->paymentPointId->toString(),
            'redirectUri' => $this->redirectUri,
            'reference' => $this->reference,
            'description' => $this->description,
        ];
    }
}
