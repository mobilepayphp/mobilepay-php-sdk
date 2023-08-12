<?php

declare(strict_types=1);

namespace MobilePayPhp\MobilePay\Webhook\Request;

/**
 * @covers \MobilePayPhp\MobilePay\Webhook\Request\GetWebhooksRequest
 * @covers \MobilePayPhp\Api\IsGetTrait
 *
 * @uses \MobilePayPhp\MobilePay\Id
 *
 * @group unit
 */
final class GetWebhooksRequestTest extends AbstractWebhookRequestTest
{
    public function dataProvider(): \Generator
    {
        $expectedMethod = 'GET';
        $expectedUri = '/v1/webhooks';
        $expectedBody = null;
        yield 'construct GetWebhooksRequest' => [$expectedMethod, $expectedUri, $expectedBody, new GetWebhooksRequest()];
    }
}
