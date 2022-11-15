<?php

declare(strict_types=1);

namespace MobilePayPhp\Api;

trait IsGetTrait
{
    public function getMethod(): string
    {
        return 'GET';
    }

    /**
     * @return mixed[]|null
     */
    public function getBody(): ?array
    {
        return null;
    }
}
