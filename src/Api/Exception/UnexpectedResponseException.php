<?php

declare(strict_types=1);

namespace Jschaedl\Api\Exception;

final class UnexpectedResponseException extends ResponseException
{
    public function __construct(int $statusCode, array $payload)
    {
        $message = [];
        foreach ($payload as $key => $value) {
            $message[] = $key.': '.$value;
        }

        parent::__construct($statusCode, 'Unexpected response: '.implode(', ', $message));
    }
}
