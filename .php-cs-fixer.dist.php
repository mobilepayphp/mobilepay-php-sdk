<?php

declare(strict_types=1);

$finder = (new PhpCsFixer\Finder())
    ->in([
        __DIR__.'/src',
    ])
    ->append([__FILE__, '.php-cs-fixer.dist.php'])
;

return (new PhpCsFixer\Config())
    ->setRiskyAllowed(true)
    ->setRules([
        '@Symfony' => true,
        '@PHP80Migration' => true,
        '@PHP80Migration:risky' => true,
        '@PHP81Migration' => true,
        '@PHP82Migration' => true,
        'php_unit_method_casing' => false,
        'php_unit_test_case_static_method_calls' => ['call_type' => 'static'],
    ])
    ->setFinder($finder)
;
