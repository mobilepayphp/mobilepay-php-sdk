<?php

declare(strict_types=1);

namespace Jschaedl\MobilePay\AppPayment\Payments;

use Jschaedl\Api\IsGetTrait;
use Jschaedl\Api\RequestInterface;
use Jschaedl\MobilePay\AppPayment\Id;

/**
 * @see \Jschaedl\MobilePay\AppPayment\Payments\GetPaymentRequestTest
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
