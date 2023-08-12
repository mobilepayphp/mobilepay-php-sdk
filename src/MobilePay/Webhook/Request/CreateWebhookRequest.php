<?php

declare(strict_types=1);

namespace MobilePayPhp\MobilePay\Webhook\Request;

use MobilePayPhp\Api\IsPostTrait;
use MobilePayPhp\Api\RequestInterface;
use MobilePayPhp\MobilePay\Id;
use MobilePayPhp\MobilePay\Webhook\Event;

/**
 * @internal
 */
final class CreateWebhookRequest implements RequestInterface
{
    use IsPostTrait;

    /**
     * @param list<Event> $events
     */
    public function __construct(
        private readonly array $events,
        private readonly string $url,
        private readonly ?Id $paymentPointId = null
    ) {
    }

    public function getUri(): string
    {
        return '/v1/webhooks';
    }

    public function getBody(): array
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
