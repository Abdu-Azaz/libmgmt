<?php

namespace App\Filament\Resources\StudentResource\Pages;

use App\Filament\Resources\StudentResource;
use App\Models\Student;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditStudent extends EditRecord
{
    protected static string $resource = StudentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
    protected function mutateFormDataBeforeFill(array $data): array
    {
        $student = Student::find($this->record->id);

        $data['user'] = [
            'name' => $student->user->name,
            'email' => $student->user->email,
        ];

        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $student = Student::find($this->record->id);

        // Update the user
        $student->user->update([
            'name' => $data['user']['name'],
            'email' => $data['user']['email'],
            // Only update the password if it was provided
            'password' => isset($data['user']['password']) ? bcrypt($data['user']['password']) : $student->user->password,
        ]);

        // Remove the user data from the array to avoid trying to insert it into the students table
        unset($data['user']);

        return $data;
    }
}
