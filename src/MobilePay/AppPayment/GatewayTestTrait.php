<?php

declare(strict_types=1);

namespace Jschaedl\MobilePay\AppPayment;

use Jschaedl\Api\Client;
use Jschaedl\Api\ClientInterface;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpClient\Psr18Client;

/**
 * @codeCoverageIgnore
 */
trait GatewayTestTrait
{
    private PaymentsGateway $paymentsGateway;

    private function getMobilePayClient(): ClientInterface
    {
        $apiHost = 'https://api.sandbox.mobilepay.dk';
        $apiKey = (string) getenv('MOBILEPAY_API_KEY');

        if ('' === $apiKey) {
            static::markTestSkipped('no api key is set, check your MOBILEPAY_API_KEY envvar');
        }

        $httpClient = HttpClient::create();
        $psr18HttpClient = new Psr18Client($httpClient);

        return new Client($psr18HttpClient, $psr18HttpClient, $psr18HttpClient, new ResponseHandler(), $apiHost, $apiKey);
    }

    private function createPayment(): Id
    {
        return $this->paymentsGateway
            ->createPayment(
                Amount::fromFloat(1.00),
                Id::create()->toString(),
                'https://redirect',
                'reference',
                'description'
            )
            ->getPaymentId();
    }
}
