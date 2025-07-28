<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryResource\Pages;
use App\Filament\Resources\CategoryResource\RelationManagers;
use App\Models\Category;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Filters\SelectFilter;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Products';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('category_name')
                    ->label('Category Name')
                    ->required()
                    ->maxLength(255),

                Textarea::make('category_description')
                    ->label('Description')
                    ->maxLength(65535)
                    ->columnSpanFull(),

                Forms\Components\SpatieMediaLibraryFileUpload::make('icon')
                    ->label('Icon')
                    ->directory('category-icons')
                    ->preserveFileNames()
                    ->nullable(),

                Forms\Components\SpatieMediaLibraryFileUpload::make('image')
                    ->label('Image')
                    ->directory('category-images')
                    ->preserveFileNames()
                    ->nullable(),

                TextInput::make('placeholder')
                    ->label('Placeholder')
                    ->maxLength(255)
                    ->nullable(),

                Toggle::make('active')
                    ->label('Active')
                    ->default(true),

                Select::make('parent_id')
                    ->label('Parent Category')
                    ->relationship('parent', 'category_name')
                    ->searchable()
                    ->nullable()
                    ->preload(),

                TextInput::make('created_by')
                    ->label('Created By')
                    ->maxLength(255)
                    ->disabled()
                    ->hiddenOn(['create', 'edit']),

                TextInput::make('updated_by')
                    ->label('Updated By')
                    ->maxLength(255)
                    ->disabled()
                    ->hiddenOn(['create', 'edit']),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('category_name')
                    ->label('Category Name')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('parent.category_name')
                    ->label('Parent Category')
                    ->searchable()
                    ->sortable(),

                IconColumn::make('active')
                    ->label('Status')
                    ->boolean()
                    ->trueIcon('heroicon-s-check-circle')
                    ->falseIcon('heroicon-s-x-circle')
                    ->alignment('center'),

                TextColumn::make('created_at')
                    ->label('Created Date')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('parent_id')
                    ->label('Parent Category')
                    ->relationship('parent', 'category_name')
                    ->searchable(),
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
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }
}
