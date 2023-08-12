<?php

declare(strict_types=1);

namespace MobilePayPhp\MobilePay\Webhook\Request;

use MobilePayPhp\Api\IsGetTrait;
use MobilePayPhp\Api\RequestInterface;
use MobilePayPhp\MobilePay\Id;

/**
 * @internal
 *
 * @see \MobilePayPhp\MobilePay\Webhook\GetWebhookRequest
 */
final class GetWebhookRequest implements RequestInterface
{
    use IsGetTrait;

    public function __construct(
        private readonly Id $webhookId
    ) {
    }

    public function getUri(): string
    {
        return sprintf('/v1/webhooks/%s', $this->webhookId->toString());
    }
}
