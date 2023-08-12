<?php

declare(strict_types=1);

namespace MobilePayPhp\MobilePay\AppPayment\Refunds;

use MobilePayPhp\Api\IsGetTrait;
use MobilePayPhp\Api\RequestInterface;
use MobilePayPhp\MobilePay\Id;

/**
 * @see \MobilePayPhp\MobilePay\AppPayment\Refunds\GetRefundRequestTest
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
