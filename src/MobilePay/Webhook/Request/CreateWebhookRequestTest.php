<?php

declare(strict_types=1);

namespace MobilePayPhp\MobilePay\Webhook\Request;

use MobilePayPhp\MobilePay\Id;
use MobilePayPhp\MobilePay\Webhook\Event;

/**
 * @covers \MobilePayPhp\MobilePay\Webhook\Request\CreateWebhookRequest
 * @covers \MobilePayPhp\Api\IsPostTrait
 *
 * @uses \MobilePayPhp\MobilePay\Webhook\Event
 * @uses \MobilePayPhp\MobilePay\Id
 *
 * @group unit
 */
final class CreateWebhookRequestTest extends AbstractWebhookRequestTest
{
    public function dataProvider(): \Generator
    {
        $expectedMethod = 'POST';
        $expectedUri = '/v1/webhooks';
        $expectedBody = [
            'events' => [
                'payment.reserved',
            ],
            'url' => 'webhook_uri',
        ];
        yield 'construct CreateWebhookRequest without PaymentPointId' => [$expectedMethod, $expectedUri, $expectedBody, new CreateWebhookRequest([Event::paymentReservedEvent()], 'webhook_uri')];

        $expectedBody = [
            'events' => [
                'payment.reserved',
            ],
            'url' => 'webhook_uri',
            'paymentPointId' => '57f43518-c9bf-40ff-b196-b10ef8a5b074',
        ];
        yield 'construct CreateWebhookRequest with PaymentPointId' => [$expectedMethod, $expectedUri, $expectedBody, new CreateWebhookRequest([Event::paymentReservedEvent()], 'webhook_uri', Id::fromString('57f43518-c9bf-40ff-b196-b10ef8a5b074'))];
    }
}
