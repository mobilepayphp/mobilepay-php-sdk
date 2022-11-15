<?php

declare(strict_types=1);

namespace MobilePayPhp\Api;

interface ResponseInterface
{
    public function getStatusCode(): int;

    public function getBody(): array;
}
