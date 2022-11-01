<?php

declare(strict_types=1);

namespace Jschaedl\MobilePay\AppPayment;

use Jschaedl\Api\ClientInterface;
use Jschaedl\MobilePay\AppPayment\Refunds\CreateRefundRequest;
use Jschaedl\MobilePay\AppPayment\Refunds\CreateRefundResponse;
use Jschaedl\MobilePay\AppPayment\Refunds\GetRefundRequest;
use Jschaedl\MobilePay\AppPayment\Refunds\GetRefundResponse;
use Jschaedl\MobilePay\AppPayment\Refunds\GetRefundsRequest;
use Jschaedl\MobilePay\AppPayment\Refunds\GetRefundsResponse;

/**
 * @see \Jschaedl\MobilePay\AppPayment\RefundsGatewayTest
 */
final class RefundsGateway
{
    public function __construct(private readonly ClientInterface $client)
    {
    }

    public function getRefunds(int $pageNumber = null, int $pageSize = null): GetRefundsResponse
    {
        return GetRefundsResponse::fromResponse(
            $this->client->request(
                new GetRefundsRequest($pageNumber, $pageSize)
            )
        );
    }

    public function getRefund(Id $refundId): GetRefundResponse
    {
        return GetRefundResponse::fromResponse(
            $this->client->request(
                new GetRefundRequest($refundId)
            )
        );
    }

    public function createRefund(Id $paymentId, Amount $amount, string $idempotencyKey, string $reference, string $description = ''): CreateRefundResponse
    {
        return CreateRefundResponse::fromResponse(
            $this->client->request(
                new CreateRefundRequest($paymentId, $amount, $idempotencyKey, $reference, $description)
            )
        );
    }
}
