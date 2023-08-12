<?php

declare(strict_types=1);

namespace MobilePayPhp\MobilePay\Webhook\Response;

use MobilePayPhp\Api\ResponseInterface;
use MobilePayPhp\MobilePay\Id;
use MobilePayPhp\MobilePay\Webhook\Event;

final class SingleWebhook
{
    /** @var Event[] */
    private readonly array $events;

    private readonly string $signatureKey;
    private readonly string $url;
    private readonly Id $webhookId;

    private readonly ?Id $paymentPointId;

    /**
     * @param array{ events: array<string>, signatureKey: string, url: string, webhookId: string, paymentPointId?: string } $payload
     */
    public function __construct(array $payload)
    {
        $this->events = array_map(static fn (string $event): Event => new Event($event), $payload['events']);

        $this->signatureKey = $payload['signatureKey'];
        $this->url = $payload['url'];
        $this->webhookId = Id::fromString($payload['webhookId']);

        $this->paymentPointId = isset($payload['paymentPointId']) ? Id::fromString($payload['paymentPointId']) : null;
    }

    public static function fromResponse(ResponseInterface $response): self
    {
        /* @phpstan-ignore-next-line */
        return new self($response->getBody());
    }

    /**
     * @return Event[]
     */
    public function getEvents(): array
    {
        return $this->events;
    }

    public function getSignatureKey(): string
    {
        return $this->signatureKey;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function getWebhookId(): Id
    {
        return $this->webhookId;
    }

    public function getPaymentPointId(): ?Id
    {
        return $this->paymentPointId;
    }
}
