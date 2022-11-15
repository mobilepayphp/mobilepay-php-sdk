<?php

declare(strict_types=1);

namespace MobilePayPhp\Api;

use MobilePayPhp\Api\Exception\ResponseException;

interface ClientInterface
{
    /**
     * @throws ResponseException
     */
    public function request(RequestInterface $request): ResponseInterface;
}
