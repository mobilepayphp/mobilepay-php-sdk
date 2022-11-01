<?php

declare(strict_types=1);

namespace Jschaedl\MobilePay\AppPayment\Payments;

use Jschaedl\Api\IsPostTrait;
use Jschaedl\Api\RequestInterface;
use Jschaedl\MobilePay\AppPayment\Id;

/**
 * @see \Jschaedl\MobilePay\AppPayment\Payments\ReservePaymentRequestTest
 */
final class ReservePaymentRequest implements RequestInterface
{
    use IsPostTrait;

    public function __construct(private readonly Id $paymentId, private readonly ?Id $paymentSourceId = null, private readonly ?Id $userId = null)
    {
    }

    public function getUri(): string
    {
        return sprintf('/v1/integration-test/payments/%s/reserve', $this->paymentId->toString());
    }

    /**
     * @return array{paymentSourceId?: string, userId?: string}|null
     */
    public function getBody(): ?array
    {
        $payload = null;

        if (null !== $this->paymentSourceId) {
            $payload['paymentSourceId'] = $this->paymentSourceId->toString();
        }

        if (null !== $this->userId) {
            $payload['userId'] = $this->userId->toString();
        }

        return $payload;
    }
}
