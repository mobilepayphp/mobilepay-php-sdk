<?php

declare(strict_types=1);

namespace Jschaedl\MobilePay\AppPayment\Payments;

use Jschaedl\Api\IsPostTrait;
use Jschaedl\Api\RequestInterface;
use Jschaedl\MobilePay\AppPayment\Amount;
use Jschaedl\MobilePay\AppPayment\Id;

/**
 * @see \Jschaedl\MobilePay\AppPayment\Payments\CreatePaymentRequestTest
 */
final class CreatePaymentRequest implements RequestInterface
{
    use IsPostTrait;

    private readonly int $amount;
    private readonly string $description;

    public function __construct(
        Amount $amount,
        private readonly string $idempotencyKey,
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
     * @return array{amount: int, idempotencyKey: string, paymentPointId: string, redirectUri: string, reference: string, description: string}
     */
    public function getBody(): ?array
    {
        return [
            'amount' => $this->amount,
            'idempotencyKey' => $this->idempotencyKey,
            'paymentPointId' => $this->paymentPointId->toString(),
            'redirectUri' => $this->redirectUri,
            'reference' => $this->reference,
            'description' => $this->description,
        ];
    }
}
