<?php

declare(strict_types=1);

namespace MobilePayPhp\MobilePay\Webhook\Request;

use MobilePayPhp\MobilePay\Id;

/**
 * @covers \MobilePayPhp\MobilePay\Webhook\Request\DeleteWebhookRequest
 * @covers \MobilePayPhp\Api\IsDeleteTrait
 *
 * @uses \MobilePayPhp\MobilePay\Id
 *
 * @group unit
 */
final class DeleteWebhookRequestTest extends AbstractWebhookRequestTest
{
    public function dataProvider(): \Generator
    {
        $expectedMethod = 'DELETE';
        $expectedUri = '/v1/webhooks/c7dc46c1-8251-4579-9997-cba6725826bf';
        $expectedBody = null;
        yield 'construct DeleteWebhookRequest' => [$expectedMethod, $expectedUri, $expectedBody, new DeleteWebhookRequest(Id::fromString('c7dc46c1-8251-4579-9997-cba6725826bf'))];
    }
}
