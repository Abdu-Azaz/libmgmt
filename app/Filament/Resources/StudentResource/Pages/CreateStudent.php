<?php

namespace App\Filament\Resources\StudentResource\Pages;

use App\Filament\Resources\StudentResource;
use App\Models\User;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Spatie\Permission\Models\Role;

class CreateStudent extends CreateRecord
{
    protected static string $resource = StudentResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Create the user
        $user = User::create([
            'name' => $data['user']['name'],
            'email' => $data['user']['email'],
            'password' => bcrypt($data['user']['password']),
            // 'roles.name' => $data['user']['roles'],
        ]);
        $studentRole = Role::where('name', 'student')->first();
            if ($studentRole) {
                $user->roles()->attach($studentRole->id);
            }

        $data['user_id'] = $user->id;
        // dd($data);
        // Remove the user data from the array to avoid trying to insert it into the students table
        unset($data['user']);

        return $data;
    }
}
