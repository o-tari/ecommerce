<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SlideshowResource\Pages;
use App\Models\Slideshow;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SlideshowResource extends Resource
{
    protected static ?string $model = Slideshow::class;

    protected static ?string $navigationIcon = 'heroicon-o-photo';

    protected static ?string $navigationGroup = 'Content Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(80),
                Forms\Components\Textarea::make('description')
                    ->maxLength(160)
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('btn_label')
                    ->label('Button Label')
                    ->maxLength(50)
                    ->nullable(),
                Forms\Components\TextInput::make('destination_url')
                    ->label('Destination URL')
                    ->url()
                    ->maxLength(65535)
                    ->nullable()
                    ->columnSpanFull(),
                Forms\Components\Toggle::make('published')
                    ->label('Published')
                    ->required(),
                Forms\Components\TextInput::make('display_order')
                    ->label('Display Order')
                    ->numeric()
                    ->default(0)
                    ->required(),
                Forms\Components\TextInput::make('clicks')
                    ->numeric()
                    ->default(0)
                    ->disabled(),
                Forms\Components\KeyValue::make('styles')
                    ->label('Styles (JSON)')
                    ->nullable()
                    ->columnSpanFull(),
                Forms\Components\SpatieMediaLibraryFileUpload::make('slideshow_image')
                    ->label('Slideshow Image')
                    ->collection('slideshow_image')
                    ->image()
                    ->imageEditor()
                    ->nullable()
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('btn_label')
                    ->label('Button Label')
                    ->searchable(),
                Tables\Columns\TextColumn::make('destination_url')
                    ->label('URL')
                    ->searchable()
                    ->limit(30),
                Tables\Columns\IconColumn::make('published')
                    ->boolean(),
                Tables\Columns\TextColumn::make('display_order')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('clicks')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('published')
                    ->label('Published Status'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('display_order', 'asc');
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
            'index' => Pages\ListSlideshows::route('/'),
            'create' => Pages\CreateSlideshow::route('/create'),
            'edit' => Pages\EditSlideshow::route('/{record}'),
        ];
    }
}
