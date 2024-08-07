<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BookResource\Pages;
use App\Filament\Resources\BookResource\RelationManagers;
use App\Models\Book;
use Filament\Forms;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TagsColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BookResource extends Resource
{
    protected static ?string $model = Book::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';
    // protected static ?string $navigationLabel = 'Livres';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()->schema([
                    TextInput::make('title')->required(),
                    TextInput::make('isbn'),
                ])->columns(2),

                Section::make()->schema([
                    Select::make('category_id')->relationship('category','name')->preload(true),
                    Forms\Components\TextInput::make('inventory_number'),
                ])->columns(2),
                Section::make()->schema([
                    TextInput::make('quantity')->required()->numeric()->minValue(0)->reactive(),
                    TextInput::make('author')->reactive(),

                    Forms\Components\FileUpload::make('cover')->directory('booksCovers')->imageEditor(),
                ])->columns(3),
                Section::make()->schema([
                    RichEditor::make('description')->reactive()->label('Description (Soyez concis)')
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')->copyable()->wrap()
                ->sortable()->searchable(),
                TextColumn::make('isbn')->sortable()->searchable(),
                TagsColumn::make('category.name')->sortable()->searchable(),
                ImageColumn::make('cover')->sortable()->searchable(),
                TextColumn::make('quantity')->sortable()->searchable(),
                TextColumn::make('In Stock')->getStateUsing(function (Book $record) {
                    return $record->quantity - $record->reservations()->count();
                })->sortable()->searchable(),
                TextColumn::make('Out')->getStateUsing(function (Book $record) {
                    return  $record->reservations()->count();
                })->sortable()->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBooks::route('/'),
            'create' => Pages\CreateBook::route('/create'),
            'edit' => Pages\EditBook::route('/{record}/edit'),
        ];
    }
}
