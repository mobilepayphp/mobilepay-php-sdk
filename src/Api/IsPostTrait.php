<?php

declare(strict_types=1);

namespace MobilePayPhp\Api;

trait IsPostTrait
{
    public function getMethod(): string
    {
        return 'POST';
    }
}
