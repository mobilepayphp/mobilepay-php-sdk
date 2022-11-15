<?php

declare(strict_types=1);

namespace MobilePayPhp\Api\Exception;

class ServerException extends ResponseException
{
    public function __construct(int $code, string $message)
    {
        if ($code < 500) {
            throw new \InvalidArgumentException(sprintf('Class "%s" constructor argument $code must be a 5xx status code, "%d" given.', self::class, $code));
        }
        parent::__construct($code, $message);
    }
}
