<?php

declare(strict_types=1);

namespace Jschaedl\MobilePay\AppPayment\Payments;

use Jschaedl\Api\IsPostTrait;
use Jschaedl\Api\RequestInterface;
use Jschaedl\MobilePay\AppPayment\Id;

/**
 * @see \Jschaedl\MobilePay\AppPayment\Payments\CancelPaymentRequestTest
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
