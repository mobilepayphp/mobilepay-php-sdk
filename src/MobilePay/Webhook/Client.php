<?php

declare(strict_types=1);

namespace MobilePayPhp\MobilePay\Webhook;

use MobilePayPhp\Api\ClientInterface;
use MobilePayPhp\MobilePay\Id;
use MobilePayPhp\MobilePay\Webhook\Request\CreateWebhookRequest;
use MobilePayPhp\MobilePay\Webhook\Request\DeleteWebhookRequest;
use MobilePayPhp\MobilePay\Webhook\Request\GetWebhookRequest;
use MobilePayPhp\MobilePay\Webhook\Request\GetWebhooksRequest;
use MobilePayPhp\MobilePay\Webhook\Request\PublishTestNotificationRequest;
use MobilePayPhp\MobilePay\Webhook\Request\UpdateWebhookRequest;
use MobilePayPhp\MobilePay\Webhook\Response\SingleWebhook;
use MobilePayPhp\MobilePay\Webhook\Response\WebhookCollection;
use MobilePayPhp\MobilePay\Webhook\Schema\Validator;

final class Client
{
    public function __construct(
        private readonly ClientInterface $client,
        private readonly Validator $validator
    ) {
    }

    public function getWebhook(Id $webhookId): SingleWebhook
    {
        $response = $this->client->request(
            new GetWebhookRequest($webhookId)
        );

        $this->validator->validateSingleWebhookResponse($response);

        return SingleWebhook::fromResponse($response);
    }

    public function getWebhooks(): WebhookCollection
    {
        $response = $this->client->request(
            new GetWebhooksRequest()
        );

        $this->validator->validateWebhookCollectionResponse($response);

        return WebhookCollection::fromResponse($response);
    }

    public function deleteWebhook(Id $webhookId): void
    {
        $this->client->request(
            new DeleteWebhookRequest($webhookId)
        );
    }

    public function createWebhook(array $events, string $url, Id $paymentPointId = null): SingleWebhook
    {
        $request = new CreateWebhookRequest($events, $url, $paymentPointId);

        $this->validator->validateCreateWebhookRequest($request);

        $response = $this->client->request($request);

        $this->validator->validateSingleWebhookResponse($response);

        return SingleWebhook::fromResponse($response);
    }

    public function updateWebhook(Id $webhookId, array $events, string $url, Id $paymentPointId = null): SingleWebhook
    {
        $request = new UpdateWebhookRequest($webhookId, $events, $url, $paymentPointId);

        $this->validator->validateUpdateWebhookRequest($request);

        $response = $this->client->request($request);

        $this->validator->validateSingleWebhookResponse($response);

        return SingleWebhook::fromResponse($response);
    }

    public function publishTestNotification(Id $webhookId): void
    {
        $this->client->request(
            new PublishTestNotificationRequest($webhookId)
        );
    }
}
