<?php

declare(strict_types=1);

namespace Jschaedl\Api;

/**
 * @see \Jschaedl\Api\ResponseTest
 */
final class Response implements ResponseInterface
{
    public function __construct(
        private readonly int $statusCode,
        private readonly array $body = []
    ) {
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function getBody(): array
    {
        return $this->body;
    }
}
