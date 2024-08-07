<?php

namespace App\Filament\Resources;

use App\Filament\Exports\StudentExporter;
use App\Filament\Imports\StudentImporter;
use App\Filament\Resources\StudentResource\Pages;
use App\Filament\Resources\StudentResource\RelationManagers;
use App\Filament\Resources\StudentResource\RelationManagers\UserRelationManager;
use App\Filament\Resources\UserRelationManagerResource\RelationManagers\StudentRelationManager;
use App\Models\Student;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ExportAction;
use Filament\Tables\Actions\ExportBulkAction;
use Filament\Tables\Actions\ImportAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class StudentResource extends Resource
{
    protected static ?string $model = Student::class;
    protected static ?string $navigationIcon = 'heroicon-o-users';

    public static function form(Form $form): Form
    {

      
        return $form
            ->schema([
                Forms\Components\Card::make('Auth Details')
                    ->schema([
                        Forms\Components\TextInput::make('user.name')
                            ->required()
                            ->label('Name'),
                        Forms\Components\TextInput::make('user.email')
                            ->email()
                            ->required()
                            ->unique(User::class, 'email')
                            ->label('Email'),
                        Forms\Components\TextInput::make('user.password')
                            ->password()
                            ->required()
                            ->label('Password')
                            ->visible(fn($livewire) => $livewire instanceof Pages\CreateStudent)
                            ->dehydrateStateUsing(fn($state) => bcrypt($state)),
                        // Forms\Components\TextInput::make('roles')->default('student')->readOnly()

                    ])->columns(3),
                    
                Forms\Components\Card::make('Student Info')->schema([

                    Forms\Components\TextInput::make('apogee')
                        ->required()
                        ->maxLength(11)
                        ->unique(),
                    Forms\Components\TextInput::make('cne')
                        ->maxLength(12),
                    Forms\Components\TextInput::make('cin')
                        ->maxLength(12),
                    Forms\Components\TextInput::make('telephone')
                        ->maxLength(12),

                    Forms\Components\TextInput::make('filiere')
                        ->maxLength(30),
                ])->columns(3)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->headerActions([
            ImportAction::make()
                ->importer(StudentImporter::class)
                ,
                ExportAction::make()
                ->exporter(StudentExporter::class)
        ])
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Name')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('apogee')
                    ->sortable()
                    ->label('APOGEE')
                    ->searchable(),
                Tables\Columns\TextColumn::make('cne')
                    ->sortable()
                    ->label('CNE')

                    ->searchable(),
                Tables\Columns\TextColumn::make('cin')
                    ->sortable()
                    ->searchable()
                    ->label('CIN')
                    ,
                Tables\Columns\TextColumn::make('telephone')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('user.email')
                    ->label('Email')    
                ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('filiere')
                    ->sortable()
                    ->searchable(),
                // Tables\Columns\TextColumn::make('created_at')
                //     ->dateTime()
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('updated_at')
                //     ->dateTime()
                //     ->sortable(),
            ])
            ->filters([
                // Define filters if needed
            ])->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    ExportBulkAction::make()
                ->exporter(StudentExporter::class)->color('danger')
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListStudents::route('/'),
            'create' => Pages\CreateStudent::route('/create'),
            'edit' => Pages\EditStudent::route('/{record}/edit'),
        ];
    }
}
