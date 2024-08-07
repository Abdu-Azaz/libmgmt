<?php

namespace App\Filament\Imports;

use App\Models\Student;
use App\Models\User;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;
use Illuminate\Support\Facades\Hash;

class StudentImporter extends Importer
{
    protected static ?string $model = Student::class;

    
    public static function getColumns(): array
    {
        return [
            ImportColumn::make('user') 
                // ->relationship(),
                ->relationship(resolveUsing: 'email'),
            ImportColumn::make('apogee')
                ->requiredMapping()
                ->rules(['required', 'max:11']),
            ImportColumn::make('cne')
                ->rules(['max:12']),
            ImportColumn::make('cin')
                ->rules(['max:12']),
            ImportColumn::make('telephone')
                ->rules(['max:12']),
            // ImportColumn::make('email')
            //     ->rules(['email', 'max:60']),
            ImportColumn::make('filiere')
                ->rules(['max:30']),
        ];
    }

    public function resolveRecord(): ?Student
{
    // First, ensure the user record is created or updated
    // $user = User::updateOrCreate(
    //     [
    //         'email' => $this->data['email'],
    //         'name' => $this->data['name'],
    //         'password' => Hash::make($this->data['password'])
    //     ]
    // );

    // // Create or update the student record
    // $student = Student::updateOrCreate(
    //     [
    //         'user_id' => $user->id,        
    //         'cne' => $this->data['cne'],
    //         'apogee' => $this->data['apogee'],
    //         'cin' => $this->data['cin'],
    //         'telephone' => $this->data['telephone'],
    //         'filiere' => $this->data['filiere'],
    //     ]
    // );

    // return $student;
    return new Student();
}


    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your student import has completed and ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }


    // protected function beforeSave(): void
    // {
    //     dd($this->data);
    //     // Runs before a record is saved to the database.
    //     $this->data['password'] = Hash::make($this->data['cne']); 
    //     // $this->record['password'] = Hash::make($this->data['cne']);
    //     $this->saveRecord();
    // }
}
