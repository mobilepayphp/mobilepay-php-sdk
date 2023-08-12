<?php

declare(strict_types=1);

namespace MobilePayPhp\MobilePay\Webhook\Request;

use MobilePayPhp\Api\IsPostTrait;
use MobilePayPhp\Api\RequestInterface;
use MobilePayPhp\MobilePay\Id;

/**
 * @internal
 */
final class PublishTestNotificationRequest implements RequestInterface
{
    use IsPostTrait;

    public function __construct(private readonly Id $webhookId)
    {
    }

    public function getUri(): string
    {
        return sprintf('/v1/webhooks/%s/publishtestnotification', $this->webhookId->toString());
    }

    public function getBody(): ?array
    {
        return null;
    }
}
