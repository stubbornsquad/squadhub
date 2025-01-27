<?php

declare(strict_types=1);

arch()->preset()->php();
arch()->preset()->laravel();
arch()->preset()->security();

arch('expect all files to use strict types')
    ->expect('App')
    ->toUseStrictTypes();

arch('expect all files to be final')
    ->expect('App')
    ->classes()
    ->toBeFinal();

arch('expect all files to use strict equality')
    ->expect('App')
    ->toUseStrictEquality();

arch('expect all files to have properties and methods documented')
    ->expect('App')
    ->toHavePropertiesDocumented()
    ->toHaveMethodsDocumented();
