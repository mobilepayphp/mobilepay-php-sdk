<?php

declare(strict_types=1);

namespace MobilePayPhp\MobilePay\Webhook\Schema;

use MobilePayPhp\Api\JsonSchemaValidationTrait;
use MobilePayPhp\Api\ResponseInterface;
use MobilePayPhp\MobilePay\Webhook\Request\CreateWebhookRequest;
use MobilePayPhp\MobilePay\Webhook\Request\UpdateWebhookRequest;

/**
 * @internal
 *
 * @see \MobilePayPhp\MobilePay\Webhook\Schema\ValidatorTest
 */
final class Validator
{
    use JsonSchemaValidationTrait;

    public function validateSingleWebhookResponse(ResponseInterface $response): void
    {
        $this->validate($response->getBody(), __DIR__.'/SingleWebhookResponse.schema.json');
    }

    public function validateWebhookCollectionResponse(ResponseInterface $response): void
    {
        $this->validate($response->getBody(), __DIR__.'/MultipleWebhookResponse.schema.json');
    }

    public function validateCreateWebhookRequest(CreateWebhookRequest $request): void
    {
        $this->validate($request->getBody() ?? [], __DIR__.'/CreateWebhookRequest.schema.json');
    }

    public function validateUpdateWebhookRequest(UpdateWebhookRequest $request): void
    {
        $this->validate($request->getBody() ?? [], __DIR__.'/UpdateWebhookRequest.schema.json');
    }
}
