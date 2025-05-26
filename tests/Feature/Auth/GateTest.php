<?php

declare(strict_types=1);

use App\Enums\RoleEnum;
use App\Models\User;
use Illuminate\Support\Facades\Gate;

it('grants all permissions to super admins', function (): void {
    $user = User::factory()->create();
    $user->assignRole(RoleEnum::SUPER_ADMIN);

    Gate::define('some-action', fn (): false => false); // Should be overridden

    expect(Gate::forUser($user)->allows('some-action'))->toBeTrue();
});

it('respects default gates for non-super admins', function (): void {
    $user = User::factory()->create();
    $user->assignRole(RoleEnum::PLAYER);

    Gate::define('some-action', fn (): false => false);

    expect(Gate::forUser($user)->allows('some-action'))->toBeFalse();
});
