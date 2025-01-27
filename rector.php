<?php

declare(strict_types=1);

use Rector\CodeQuality\Rector\FuncCall\CompactToVariablesRector;
use Rector\Config\RectorConfig;
use Rector\Php83\Rector\ClassMethod\AddOverrideAttributeToOverriddenMethodsRector;
use RectorLaravel\Set\LaravelLevelSetList;

return RectorConfig::configure()
    ->withPaths([
        __DIR__.'/app',
        __DIR__.'/config',
        __DIR__.'/database',
        __DIR__.'/bootstrap/app.php',
        __DIR__.'/resources',
        __DIR__.'/routes',
        __DIR__.'/tests',
    ])
    ->withSkip([
        __DIR__.'/bootstrap/cache',
        CompactToVariablesRector::class,
//        AddOverrideAttributeToOverriddenMethodsRector::class,
    ])
    ->withPreparedSets(
        deadCode: true,
        codeQuality: true,
        typeDeclarations: true,
        privatization: true,
        earlyReturn: true,
        strictBooleans: true,
    )
    ->withSets([
        LaravelLevelSetList::UP_TO_LARAVEL_110,
    ])
    ->withPhpSets();
//    ->withCache(
//        cacheDirectory: (__DIR__ . '/storage/rector'),
//        cacheClass: FileCacheStorage::class,
//    )
