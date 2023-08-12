<?php

declare(strict_types=1);

namespace MobilePayPhp\MobilePay\Webhook\Schema;

use MobilePayPhp\Api\Response;
use PHPUnit\Framework\TestCase;

final class ValidatorTest extends TestCase
{
    /**
     * @var string
     */
    private const JSON = <<<'JSON'
        {

        }
        JSON;

    public function test_validate_SingleWebhookResponse(): void
    {
        static::markTestSkipped();

        $payload = json_decode(self::JSON, true, 512, JSON_THROW_ON_ERROR);
        $response = new Response(200, $payload);

        $validator = new Validator();
        $validator->validateSingleWebhookResponse($response);
    }
}
