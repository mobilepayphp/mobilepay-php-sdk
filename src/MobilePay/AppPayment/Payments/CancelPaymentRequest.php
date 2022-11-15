<?php

declare(strict_types=1);

namespace MobilePayPhp\MobilePay\AppPayment\Payments;

use MobilePayPhp\Api\IsPostTrait;
use MobilePayPhp\Api\RequestInterface;
use MobilePayPhp\MobilePay\AppPayment\Id;

/**
 * @see \MobilePayPhp\MobilePay\AppPayment\Payments\CancelPaymentRequestTest
 */
final class CancelPaymentRequest implements RequestInterface
{
    use IsPostTrait;

    private readonly string $paymentId;

    public function __construct(Id $paymentId, private readonly ?string $idempotencyKey = null)
    {
        $this->paymentId = $paymentId->toString();
    }

    public function getUri(): string
    {
        return sprintf('/v1/payments/%s/cancel', $this->paymentId);
    }

    /**
     * @return mixed[]|null
     */
    public function getBody(): ?array
    {
        return $this->idempotencyKey
            ? ['idempotencyKey' => $this->idempotencyKey]
            : null
        ;
    }
}
