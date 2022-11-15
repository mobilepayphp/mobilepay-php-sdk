<?php

declare(strict_types=1);

namespace MobilePayPhp\Api;

use MobilePayPhp\Api\Exception\ResponseException;

interface ResponseHandlerInterface
{
    /**
     * @throws ResponseException
     */
    public function handle(int $statusCode, array $body): Response;
}
