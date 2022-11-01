<?php

declare(strict_types=1);

namespace Jschaedl\MobilePay\AppPayment\Refunds;

use Jschaedl\Api\IsGetTrait;
use Jschaedl\Api\RequestInterface;
use Jschaedl\MobilePay\AppPayment\Id;

/**
 * @see \Jschaedl\MobilePay\AppPayment\Refunds\GetRefundRequestTest
 */
final class GetRefundRequest implements RequestInterface
{
    use IsGetTrait;

    public function __construct(private readonly Id $refundId)
    {
    }

    public function getUri(): string
    {
        return sprintf('/v1/refunds/%s', $this->refundId->toString());
    }
}
