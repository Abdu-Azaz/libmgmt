<?php

namespace App\Filament\Resources;

use App\Filament\Exports\UserExporter;
use App\Filament\Imports\UserImporter;
use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Pages\Page;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ExportAction;
use Filament\Tables\Actions\ImportAction;
use Filament\Tables\Table;
use Hash;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Roles and Permissions';
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()->schema([
                    Forms\Components\TextInput::make('name')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('email')
                        ->email()
                        ->required()
                        ->maxLength(255),
                ])->columns('2'),

                Section::make()->schema([
                    Forms\Components\TextInput::make('password')
                        ->password()
                        ->required()
                        ->dehydrateStateUsing(
                            static fn(null|string $state): null|string =>
                            filled($state) ? Hash::make($state) : null,
                        )->required(
                            static fn(Page $livewire): bool =>
                            $livewire instanceof CreateUser,
                        )->dehydrated(
                            static fn(null|string $state): bool =>
                            filled($state),
                        )->label(
                            static fn(Page $livewire): string => ($livewire instanceof EditUser) ? 'New Password' : 'Password'
                        )
                        ->maxLength(255),
                    // Forms\Components\Toggle::make('is_admin')
                    //     ->required()
                    //     ->helperText('Is this SA'),

                    Select::make('roles')->relationship('roles', 'name')
                ])->columns('2'),
                // CheckboxList::make('Roles')->relationship('roles', 'name')->columns('2'),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->headerActions([
            ImportAction::make()
                ->importer(UserImporter::class)
                ,
                ExportAction::make()
                ->exporter(UserExporter::class)
        ])
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('roles.name'), 
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageUsers::route('/'),
        ];
    }
}
