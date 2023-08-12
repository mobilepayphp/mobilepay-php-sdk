<?php

declare(strict_types=1);

use Rector\CodeQuality\Rector\Class_\InlineConstructorDefaultToPropertyRector;
use Rector\Config\RectorConfig;
use Rector\PHPUnit\Rector\Class_\AddSeeTestAnnotationRector;
use Rector\Set\ValueObject\LevelSetList;
use Rector\Set\ValueObject\SetList;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->paths([
        __DIR__.'/src',
    ]);

    $rectorConfig->skip([
        // bug: rector ends in an error refactoring this class
        __DIR__.'/src/MobilePay/AppPayment/PaymentPoints/PaymentPointState.php',
        // bug: rector applies FinalizeClassesWithoutChildrenRector
        __DIR__.'/src/Api/Exception/ClientException.php',
    ]);

    $rectorConfig->rules([
        InlineConstructorDefaultToPropertyRector::class,
        AddSeeTestAnnotationRector::class,
    ]);
    $rectorConfig->sets([
        LevelSetList::UP_TO_PHP_81,
        SetList::CODE_QUALITY,
        SetList::DEAD_CODE,
        SetList::EARLY_RETURN,
        SetList::TYPE_DECLARATION,
        SetList::PRIVATIZATION,
    ]);
};
