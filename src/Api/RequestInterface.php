<?php

declare(strict_types=1);

namespace MobilePayPhp\Api;

interface RequestInterface
{
    public function getMethod(): string;

    public function getUri(): string;

    public function getBody(): ?array;
}
