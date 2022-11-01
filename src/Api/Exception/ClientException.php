<?php

declare(strict_types=1);

namespace Jschaedl\Api\Exception;

class ClientException extends ResponseException
{
    public function __construct(int $code, string $message)
    {
        if (!(400 <= $code && $code < 500)) {
            throw new \InvalidArgumentException(sprintf('Class "%s" constructor argument $code must be a 4xx status code, "%d" given.', self::class, $code));
        }
        parent::__construct($code, $message);
    }
}
