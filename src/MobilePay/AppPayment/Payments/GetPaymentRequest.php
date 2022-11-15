<?php

declare(strict_types=1);

namespace MobilePayPhp\MobilePay\AppPayment\Payments;

use MobilePayPhp\Api\IsGetTrait;
use MobilePayPhp\Api\RequestInterface;
use MobilePayPhp\MobilePay\AppPayment\Id;

/**
 * @see \MobilePayPhp\MobilePay\AppPayment\Payments\GetPaymentRequestTest
 */
final class GetPaymentRequest implements RequestInterface
{
    use IsGetTrait;

    public function __construct(private readonly Id $paymentId)
    {
    }

    public function getUri(): string
    {
        return sprintf('/v1/payments/%s', $this->paymentId->toString());
    }
}
