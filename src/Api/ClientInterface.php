<?php

declare(strict_types=1);

namespace Jschaedl\Api;

use Jschaedl\Api\Exception\ResponseException;

interface ClientInterface
{
    /**
     * @throws ResponseException
     */
    public function request(RequestInterface $request): ResponseInterface;
}
