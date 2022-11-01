<?php

declare(strict_types=1);

namespace Jschaedl\MobilePay\AppPayment\PaymentPoints;

use Jschaedl\Api\Validation\ValidationRule;
use Jschaedl\Api\Validation\ValidationTrait;
use Jschaedl\MobilePay\AppPayment\Id;

/**
 * @see \Jschaedl\MobilePay\AppPayment\PaymentPoints\GetPaymentPointResponseTest
 */
final class GetPaymentPointResponse
{
    use ValidationTrait;

    private readonly Id $paymentPointId;
    private readonly string $paymentPointName;
    private readonly PaymentPointState $state;

    public function __construct(array $payload)
    {
        self::validate(
            $payload,
            ValidationRule::mandatoryString('paymentPointId'),
            ValidationRule::optionalString('paymentPointName'),
            ValidationRule::mandatoryString('state'),
        );

        $this->paymentPointId = Id::fromString((string) $payload['paymentPointId']);
        $this->paymentPointName = (string) $payload['paymentPointName'];
        $this->state = new PaymentPointState((string) $payload['state']);
    }

    public function getPaymentPointId(): Id
    {
        return $this->paymentPointId;
    }

    public function getPaymentPointName(): string
    {
        return $this->paymentPointName;
    }

    public function getState(): PaymentPointState
    {
        return $this->state;
    }
}
