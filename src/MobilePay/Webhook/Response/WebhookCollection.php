<?php

declare(strict_types=1);

namespace MobilePayPhp\MobilePay\Webhook\Response;

use MobilePayPhp\Api\ResponseInterface;

final class WebhookCollection
{
    /**
     * @var SingleWebhook[]
     */
    private readonly array $webhooks;

    /**
     * @param array{webhooks: array{ events: array, signatureKey: string, url: string, webhookId: string, paymentPointId?: string }} $payload
     */
    public function __construct(array $payload)
    {
        $this->webhooks = array_map(fn (array $singleWebhook): SingleWebhook => new SingleWebhook($singleWebhook), $payload['webhooks']);
    }

    public static function fromResponse(ResponseInterface $response): self
    {
        return new self($response->getBody());
    }

    /**
     * @return SingleWebhook[]
     */
    public function getWebhooks(): array
    {
        return $this->webhooks;
    }
}
