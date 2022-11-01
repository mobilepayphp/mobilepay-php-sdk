<?php

declare(strict_types=1);

use Rector\CodeQuality\Rector\Class_\InlineConstructorDefaultToPropertyRector;
use Rector\Config\RectorConfig;
use Rector\PHPUnit\Rector\Class_\AddSeeTestAnnotationRector;
use Rector\Set\ValueObject\LevelSetList;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->paths([
        __DIR__ . '/src'
    ]);

    # php
    $rectorConfig->sets([LevelSetList::UP_TO_PHP_80]);
    $rectorConfig->sets([LevelSetList::UP_TO_PHP_81]);

    $rectorConfig->rule(InlineConstructorDefaultToPropertyRector::class);

    # phpunit
    $rectorConfig->rule(AddSeeTestAnnotationRector::class);
};
