<?php

declare(strict_types=1);

namespace Jschaedl\MobilePay\AppPayment\Payments;

use Jschaedl\Api\IsPostTrait;
use Jschaedl\Api\RequestInterface;
use Jschaedl\MobilePay\AppPayment\Amount;
use Jschaedl\MobilePay\AppPayment\Id;

/**
 * @see \Jschaedl\MobilePay\AppPayment\Payments\CapturePaymentRequestTest
 */
final class CapturePaymentRequest implements RequestInterface
{
    use IsPostTrait;
    private readonly int $amount;

    public function __construct(private readonly Id $paymentId, Amount $amount)
    {
        $this->amount = $amount->getAmountInCent();
    }

    public function getUri(): string
    {
        return sprintf('/v1/payments/%s/capture', $this->paymentId->toString());
    }

    /**
     * @return array{amount: int}
     */
    public function getBody(): ?array
    {
        return ['amount' => $this->amount];
    }
}
