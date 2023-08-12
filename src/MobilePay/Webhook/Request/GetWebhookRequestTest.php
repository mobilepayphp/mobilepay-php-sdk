<?php

declare(strict_types=1);

namespace MobilePayPhp\MobilePay\Webhook\Request;

use MobilePayPhp\MobilePay\Id;

/**
 * @covers \MobilePayPhp\MobilePay\Webhook\Request\GetWebhookRequest
 * @covers \MobilePayPhp\Api\IsGetTrait
 *
 * @uses \MobilePayPhp\MobilePay\Id
 *
 * @group unit
 */
final class GetWebhookRequestTest extends AbstractWebhookRequestTest
{
    public function dataProvider(): \Generator
    {
        $expectedMethod = 'GET';
        $expectedUri = '/v1/webhooks/c7dc46c1-8251-4579-9997-cba6725826bf';
        $expectedBody = null;
        yield 'construct GetWebhookRequest' => [$expectedMethod, $expectedUri, $expectedBody, new GetWebhookRequest(Id::fromString('c7dc46c1-8251-4579-9997-cba6725826bf'))];
    }
}
