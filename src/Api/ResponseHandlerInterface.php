<?php

declare(strict_types=1);

namespace Jschaedl\Api;

use Jschaedl\Api\Exception\ResponseException;

interface ResponseHandlerInterface
{
    /**
     * @throws ResponseException
     */
    public function handle(int $statusCode, array $body): Response;
}
