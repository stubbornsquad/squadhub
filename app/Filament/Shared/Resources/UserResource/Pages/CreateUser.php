<?php

declare(strict_types=1);

namespace app\Filament\Shared\Resources\UserResource\Pages;

use app\Filament\Shared\Resources\UserResource;
use App\Models\User;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

final class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    /**
     * Redirects to the index page after creating a user record.
     */
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    /**
     * Assign the 'player' role to each new user.
     */
    protected function handleRecordCreation(array $data): Model
    {
        /** @var User $newUser */
        $newUser = parent::handleRecordCreation($data);
        $newUser->assignRole('player');

        return $newUser;
    }
}
