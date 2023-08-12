<?php

declare(strict_types=1);

namespace MobilePayPhp\MobilePay\Webhook\Request;

use MobilePayPhp\Api\IsGetTrait;
use MobilePayPhp\Api\RequestInterface;

/**
 * @internal
 */
final class GetWebhooksRequest implements RequestInterface
{
    use IsGetTrait;

    public function getUri(): string
    {
        return '/v1/webhooks';
    }
}
