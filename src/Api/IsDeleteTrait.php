<?php

declare(strict_types=1);

namespace MobilePayPhp\Api;

trait IsDeleteTrait
{
    public function getMethod(): string
    {
        return 'DELETE';
    }

    /**
     * @return mixed[]|null
     */
    public function getBody(): ?array
    {
        return null;
    }
}
