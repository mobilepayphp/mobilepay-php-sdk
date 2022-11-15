<?php

declare(strict_types=1);

namespace MobilePayPhp\MobilePay\AppPayment\PaymentPoints;

use MobilePayPhp\Api\Validation\ValidationRule;
use MobilePayPhp\Api\Validation\ValidationTrait;
use MobilePayPhp\MobilePay\AppPayment\Id;

/**
 * @see \MobilePayPhp\MobilePay\AppPayment\PaymentPoints\GetPaymentPointResponseTest
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
