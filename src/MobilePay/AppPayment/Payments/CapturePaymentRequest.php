<?php

declare(strict_types=1);

namespace MobilePayPhp\MobilePay\AppPayment\Payments;

use MobilePayPhp\Api\IsPostTrait;
use MobilePayPhp\Api\RequestInterface;
use MobilePayPhp\MobilePay\AppPayment\Amount;
use MobilePayPhp\MobilePay\Id;

/**
 * @see \MobilePayPhp\MobilePay\AppPayment\Payments\CapturePaymentRequestTest
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
     * @return array{amount: int}|null
     */
    public function getBody(): ?array
    {
        return ['amount' => $this->amount];
    }
}
