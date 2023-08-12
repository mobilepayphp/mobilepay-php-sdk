<?php

declare(strict_types=1);

namespace MobilePayPhp\MobilePay\Webhook\Request;

use MobilePayPhp\Api\IsDeleteTrait;
use MobilePayPhp\Api\RequestInterface;
use MobilePayPhp\MobilePay\Id;

/**
 * @internal
 */
final class DeleteWebhookRequest implements RequestInterface
{
    use IsDeleteTrait;

    public function __construct(
        private readonly Id $webhookId
    ) {
    }

    public function getUri(): string
    {
        return sprintf('/v1/webhooks/%s', $this->webhookId->toString());
    }
}