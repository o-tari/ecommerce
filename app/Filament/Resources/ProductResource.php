<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Filters\SelectFilter;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Products';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\SpatieMediaLibraryFileUpload::make('images')
                    ->label('Images')
                    ->directory('product-images')
                    ->preserveFileNames()
                    ->nullable(),
                TextInput::make('product_name')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),
                TextInput::make('slug')
                    ->required()
                    ->maxLength(255)
                    ->columnSpan(2),
                TextInput::make('sku')
                    ->maxLength(255)
                    ->columnSpan(2),
                Forms\Components\Group::make([
                    TextInput::make('sale_price')
                        ->required()
                        ->numeric()
                        ->prefix('$'),
                    TextInput::make('compare_price')
                        ->required()
                        ->numeric()
                        ->prefix('$'),
                    TextInput::make('buying_price')
                        ->numeric()
                        ->prefix('$')
                        ->nullable(),
                ])->columns(3)->columnSpanFull(),
                TextInput::make('quantity')
                    ->required()
                    ->numeric()
                    ->default(0)
                    ->columnSpan(2),
                Textarea::make('short_description')
                    ->required()
                    ->maxLength(65535)
                    ->columnSpanFull(),
                Textarea::make('product_description')
                    ->required()
                    ->maxLength(65535)
                    ->columnSpanFull(),
                Toggle::make('published')
                    ->required()
                    ->columnSpan(2),
                Toggle::make('disable_out_of_stock')
                    ->required()
                    ->columnSpan(2),
                Textarea::make('note')
                    ->maxLength(65535)
                    ->columnSpanFull()
                    ->nullable(),
                Select::make('categories')
                    ->relationship('categories', 'category_name')
                    ->label('Categories')
                    ->multiple(),
                Select::make('created_by')
                    ->relationship('createdBy', 'name')
                    ->searchable()
                    ->preload()
                    ->nullable(),
                Select::make('updated_by')
                    ->relationship('updatedBy', 'name')
                    ->searchable()
                    ->preload()
                    ->nullable(),

                Forms\Components\Group::make([
                    Forms\Components\TextInput::make('weight')
                        ->numeric()
                        ->required()
                        ->reactive()
                        ->suffix(fn (Forms\Get $get) => $get('weight_unit')),

                    Forms\Components\Select::make('weight_unit')
                        ->options([
                            'kg' => 'Kilograms (kg)',
                            'lb' => 'Pounds (lb)',
                        ])
                        ->required()
                        ->reactive(),

                    Forms\Components\TextInput::make('volume')
                        ->numeric()
                        ->required()
                        ->reactive()
                        ->suffix(fn (Forms\Get $get) => $get('volume_unit')),

                    Forms\Components\Select::make('volume_unit')
                        ->options([
                            'm3' => 'Cubic Meters (m³)',
                            'ft3' => 'Cubic Feet (ft³)',
                            'cm3' => 'Cubic Centimeters (cm³)',
                            'in3' => 'Cubic Inches (in³)',
                        ])
                        ->required()
                        ->reactive(),

                    Forms\Components\TextInput::make('dimension_width')
                        ->numeric()
                        ->required()
                        ->reactive()
                        ->suffix(fn (Forms\Get $get) => $get('dimension_unit')),

                    Forms\Components\TextInput::make('dimension_height')
                        ->numeric()
                        ->required()
                        ->reactive()
                        ->suffix(fn (Forms\Get $get) => $get('dimension_unit')),

                    Forms\Components\TextInput::make('dimension_depth')
                        ->numeric()
                        ->required()
                        ->reactive()
                        ->suffix(fn (Forms\Get $get) => $get('dimension_unit')),

                    Forms\Components\Select::make('dimension_unit')
                        ->options([
                            'm' => 'Meters (m)',
                            'ft' => 'Feet (ft)',
                            'cm' => 'Centimeters (cm)',
                            'in' => 'Inches (in)',
                        ])
                        ->required()
                        ->reactive(),
                ])->relationship('shippingInfo')->label('Shipping Info')->columnSpanFull()->columns(4),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('product_name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('slug')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('sku')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('sale_price')
                    ->money()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('compare_price')
                    ->money()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('quantity')
                    ->sortable()
                    ->toggleable(),
                IconColumn::make('published')
                    ->boolean()
                    ->sortable()
                    ->toggleable(),
                IconColumn::make('disable_out_of_stock')
                    ->boolean()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('created_by.name')
                    ->label('Created By')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_by.name')
                    ->label('Updated By')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('published')
                    ->options([
                        '1' => 'Published',
                        '0' => 'Unpublished',
                    ])
                    ->attribute('published'),
                Tables\Filters\TernaryFilter::make('disable_out_of_stock')
                    ->label('Out of Stock Status')
                    ->trueLabel('Disabled')
                    ->falseLabel('Enabled')
                    ->attribute('disable_out_of_stock'),
                SelectFilter::make('created_by')
                    ->relationship('createdBy', 'name')
                    ->label('Created By'),
                SelectFilter::make('updated_by')
                    ->relationship('updatedBy', 'name')
                    ->label('Updated By'),
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
