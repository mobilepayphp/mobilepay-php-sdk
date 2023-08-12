<?php

declare(strict_types=1);

namespace MobilePayPhp\MobilePay\Webhook\Request;

use MobilePayPhp\MobilePay\Id;
use MobilePayPhp\MobilePay\Webhook\Event;

/**
 * @covers \MobilePayPhp\MobilePay\Webhook\Request\UpdateWebhookRequest
 * @covers \MobilePayPhp\Api\IsPutTrait
 *
 * @uses \MobilePayPhp\MobilePay\Webhook\Event
 * @uses \MobilePayPhp\MobilePay\Id
 *
 * @group unit
 */
final class UpdateWebhookRequestTest extends AbstractWebhookRequestTest
{
    public function dataProvider(): \Generator
    {
        $expectedMethod = 'PUT';

        $expectedUri = '/v1/webhooks/fce10004-3ef0-4b11-b192-337b70af5c72';
        $expectedBody = [
            'events' => [
                'payment.reserved',
            ],
            'url' => 'webhook_uri',
        ];
        yield 'construct UpdateWebhookRequest without PaymentPointId' => [$expectedMethod, $expectedUri, $expectedBody, new UpdateWebhookRequest(Id::fromString('fce10004-3ef0-4b11-b192-337b70af5c72'), [Event::paymentReservedEvent()], 'webhook_uri')];

        $expectedUri = '/v1/webhooks/0a8e5c4f-1fac-444f-9245-441082d65916';
        $expectedBody = [
            'events' => [
                'payment.reserved',
            ],
            'url' => 'webhook_uri',
            'paymentPointId' => '57f43518-c9bf-40ff-b196-b10ef8a5b074',
        ];
        yield 'construct UpdateWebhookRequest with PaymentPointId' => [$expectedMethod, $expectedUri, $expectedBody, new UpdateWebhookRequest(Id::fromString('0a8e5c4f-1fac-444f-9245-441082d65916'), [Event::paymentReservedEvent()], 'webhook_uri', Id::fromString('57f43518-c9bf-40ff-b196-b10ef8a5b074'))];
    }
}
