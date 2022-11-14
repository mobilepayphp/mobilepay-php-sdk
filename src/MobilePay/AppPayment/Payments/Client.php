<?php

declare(strict_types=1);

namespace Jschaedl\MobilePay\AppPayment\Payments;

use Jschaedl\Api\ClientInterface;
use Jschaedl\MobilePay\AppPayment\Amount;
use Jschaedl\MobilePay\AppPayment\Id;

/**
 * @see \Jschaedl\MobilePay\AppPayment\Payments\ClientTest
 */
final class Client
{
    private readonly Id $paymentPointId;

    public function __construct(private readonly ClientInterface $client, string $paymentPointId)
    {
        $this->paymentPointId = Id::fromString($paymentPointId);
    }

    public function cancelPayment(Id $paymentId): void
    {
        $this->client->request(new CancelPaymentRequest($paymentId));
    }

    public function capturePayment(Id $paymentId, Amount $amount): void
    {
        $this->client->request(new CapturePaymentRequest($paymentId, $amount));
    }

    public function createPayment(Amount $amount, string $idempotencyKey, string $redirectUri, string $reference, string $description = ''): CreatePaymentResponse
    {
        return CreatePaymentResponse::fromResponse(
            $this->client->request(
                new CreatePaymentRequest($amount, $idempotencyKey, $this->paymentPointId, $redirectUri, $reference, $description)
            )
        );
    }

    public function getPayment(Id $paymentId): GetPaymentResponse
    {
        return GetPaymentResponse::fromResponse(
            $this->client->request(
                new GetPaymentRequest($paymentId)
            )
        );
    }

    public function getPayments(int $pageNumber = null, int $pageSize = null): GetPaymentsResponse
    {
        return GetPaymentsResponse::fromResponse(
            $this->client->request(
                new GetPaymentsRequest($pageNumber, $pageSize)
            )
        );
    }

    public function reservePayment(Id $paymentId, Id $paymentSourceId, Id $userId): void
    {
        $this->client->request(
            new ReservePaymentRequest($paymentId, $paymentSourceId, $userId)
        );
    }
}
