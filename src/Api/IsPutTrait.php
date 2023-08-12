<?php

declare(strict_types=1);

namespace MobilePayPhp\Api;

trait IsPutTrait
{
    public function getMethod(): string
    {
        return 'PUT';
    }
}
