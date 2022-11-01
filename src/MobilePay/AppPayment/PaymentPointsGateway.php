<?php

declare(strict_types=1);

namespace Jschaedl\MobilePay\AppPayment;

use Jschaedl\Api\ClientInterface;
use Jschaedl\MobilePay\AppPayment\PaymentPoints\GetPaymentPointsRequest;
use Jschaedl\MobilePay\AppPayment\PaymentPoints\GetPaymentPointsResponse;

/**
 * @see \Jschaedl\MobilePay\AppPayment\PaymentPointsGatewayTest
 */
final class PaymentPointsGateway
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
