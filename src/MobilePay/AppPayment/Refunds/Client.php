<?php

declare(strict_types=1);

namespace MobilePayPhp\MobilePay\AppPayment\Refunds;

use MobilePayPhp\Api\ClientInterface;
use MobilePayPhp\MobilePay\AppPayment\Amount;
use MobilePayPhp\MobilePay\AppPayment\Id;

/**
 * @see \MobilePayPhp\MobilePay\AppPayment\Refunds\ClientTest
 */
final class Client
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

    public function createRefund(Id $paymentId, Amount $amount, Id $idempotencyKey, string $reference, string $description = ''): CreateRefundResponse
    {
        return CreateRefundResponse::fromResponse(
            $this->client->request(
                new CreateRefundRequest($paymentId, $amount, $idempotencyKey, $reference, $description)
            )
        );
    }
}
