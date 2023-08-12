<?php

declare(strict_types=1);

namespace MobilePayPhp\MobilePay\Webhook\Request;

use MobilePayPhp\Api\IsPutTrait;
use MobilePayPhp\Api\RequestInterface;
use MobilePayPhp\MobilePay\Id;
use MobilePayPhp\MobilePay\Webhook\Event;

/**
 * @internal
 */
final class UpdateWebhookRequest implements RequestInterface
{
    use IsPutTrait;

    /**
     * @param Event[] $events
     */
    public function __construct(
        private readonly Id $webhookId,
        private readonly array $events,
        private readonly string $url,
        private readonly ?Id $paymentPointId = null
    ) {
    }

    public function getUri(): string
    {
        return sprintf('/v1/webhooks/%s', $this->webhookId->toString());
    }

    public function getBody(): ?array
    {
        $body = [
            'events' => array_map(static fn (Event $event): string => $event->getEvent(), $this->events),
            'url' => $this->url,
        ];

        if (null !== $this->paymentPointId) {
            $body['paymentPointId'] = $this->paymentPointId->toString();
        }

        return $body;
    }
}
