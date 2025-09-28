<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';

    protected static ?string $navigationGroup = 'Sales Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\Select::make('order_status_id')
                    ->relationship('orderStatus', 'status_name')
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\TextInput::make('order_number')
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true),
                Forms\Components\TextInput::make('subtotal')
                    ->numeric()
                    ->prefix('$')
                    ->required(),
                Forms\Components\TextInput::make('tax_amount')
                    ->numeric()
                    ->prefix('$')
                    ->required(),
                Forms\Components\TextInput::make('shipping_amount')
                    ->numeric()
                    ->prefix('$')
                    ->required(),
                Forms\Components\TextInput::make('discount_amount')
                    ->numeric()
                    ->prefix('$')
                    ->required(),
                Forms\Components\TextInput::make('total_amount')
                    ->numeric()
                    ->prefix('$')
                    ->required(),
                Forms\Components\Select::make('coupon_id')
                    ->relationship('coupon', 'code')
                    ->searchable()
                    ->preload()
                    ->nullable(),
                Forms\Components\TextInput::make('shipping_address')
                    ->maxLength(65535)
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('billing_address')
                    ->maxLength(65535)
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('notes')
                    ->maxLength(65535)
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('order_number')
                    ->searchable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('orderStatus.status_name')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Pending' => 'warning',
                        'Processing' => 'info',
                        'Shipped' => 'primary',
                        'Delivered' => 'success',
                        'Cancelled' => 'danger',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('total_amount')
                    ->money('USD')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('order_status_id')
                    ->relationship('orderStatus', 'status_name')
                    ->label('Order Status'),
                Tables\Filters\SelectFilter::make('user_id')
                    ->relationship('user', 'name')
                    ->label('User'),
                Tables\Filters\Filter::make('created_at')
                    ->form([
                        Forms\Components\DatePicker::make('created_from'),
                        Forms\Components\DatePicker::make('created_until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    })
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            RelationManagers\OrderItemsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'view' => Pages\ViewOrder::route('/{record}'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
