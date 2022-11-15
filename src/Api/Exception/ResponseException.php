<?php

declare(strict_types=1);

namespace MobilePayPhp\Api\Exception;

class ResponseException extends \RuntimeException
{
    public function __construct(int $code, string $message)
    {
        parent::__construct(sprintf('%d %s', $code, $message));
    }
}
