<?php

declare(strict_types=1);

namespace MobilePayPhp\MobilePay\AppPayment\PaymentPoints;

use MobilePayPhp\Api\ClientInterface;

/**
 * @see \MobilePayPhp\MobilePay\AppPayment\PaymentPointsGatewayTest
 */
final class Client
{
    public function __construct(private readonly ClientInterface $client)
    {
    }

    public function getPaymentPoints(int $pageNumber = null, int $pageSize = null): GetPaymentPointsResponse
    {
        return GetPaymentPointsResponse::fromResponse(
            $this->client->request(
                new GetPaymentPointsRequest($pageNumber, $pageSize)
            )
        );
    }
}
