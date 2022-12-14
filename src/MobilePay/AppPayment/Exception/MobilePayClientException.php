<?php

declare(strict_types=1);

namespace MobilePayPhp\MobilePay\AppPayment\Exception;

use MobilePayPhp\Api\Exception\ClientException;
use MobilePayPhp\Api\Validation\ValidationRule;
use MobilePayPhp\Api\Validation\ValidationTrait;

class MobilePayClientException extends ClientException
{
    use ValidationTrait;

    public function __construct(
        int $statusCode,
        array $payload,
    ) {
        self::validate(
            $payload,
            ValidationRule::optionalString('code'),
            ValidationRule::optionalString('message'),
            ValidationRule::mandatoryString('correlationId'),
            ValidationRule::mandatoryString('origin')
        );

        $code = isset($payload['code']) ? (string) $payload['code'] : '';
        $message = isset($payload['message']) ? (string) $payload['message'] : '';

        $exceptionMessageParts = [];

        if (!empty($code)) {
            $exceptionMessageParts[] = 'code: '.$code;
        }

        if (!empty($message)) {
            $exceptionMessageParts[] = 'message: '.$message;
        }

        $exceptionMessageParts[] = 'correlationId: '.$payload['correlationId'];
        $exceptionMessageParts[] = 'origin: '.$payload['origin'];

        parent::__construct($statusCode, implode('; ', $exceptionMessageParts));
    }
}
