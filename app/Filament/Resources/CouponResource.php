<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CouponResource\Pages;
use App\Models\Coupon;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CouponResource extends Resource
{
    protected static ?string $model = Coupon::class;

    protected static ?string $navigationIcon = 'heroicon-o-ticket';

    protected static ?string $navigationGroup = 'Sales Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('code')
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true),
                Forms\Components\TextInput::make('discount_value')
                    ->numeric()
                    ->required()
                    ->prefix('$'),
                Forms\Components\Select::make('discount_type')
                    ->options([
                        'fixed' => 'Fixed Amount',
                        'percentage' => 'Percentage',
                    ])
                    ->required(),
                Forms\Components\TextInput::make('order_amount_limit')
                    ->numeric()
                    ->prefix('$')
                    ->nullable(),
                Forms\Components\TextInput::make('max_usage')
                    ->numeric()
                    ->nullable(),
                Forms\Components\TextInput::make('times_used')
                    ->numeric()
                    ->default(0)
                    ->disabled(),
                Forms\Components\DateTimePicker::make('coupon_start_date')
                    ->nullable(),
                Forms\Components\DateTimePicker::make('coupon_end_date')
                    ->nullable(),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('code')
                    ->searchable(),
                Tables\Columns\TextColumn::make('discount_value')
                    ->money('USD')
                    ->sortable(),
                Tables\Columns\TextColumn::make('discount_type')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'fixed' => 'success',
                        'percentage' => 'info',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('order_amount_limit')
                    ->money('USD')
                    ->sortable(),
                Tables\Columns\TextColumn::make('max_usage')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('times_used')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean(),
                Tables\Columns\TextColumn::make('expires_at')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->options([
                        'fixed' => 'Fixed Amount',
                        'percentage' => 'Percentage',
                    ]),
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Active Status'),
                Tables\Filters\Filter::make('expires_at')
                    ->form([
                        Forms\Components\DatePicker::make('expires_from'),
                        Forms\Components\DatePicker::make('expires_until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['expires_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('expires_at', '>=', $date),
                            )
                            ->when(
                                $data['expires_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('expires_at', '<=', $date),
                            );
                    })
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

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCoupons::route('/'),
            'create' => Pages\CreateCoupon::route('/create'),
            'edit' => Pages\EditCoupon::route('/{record}/edit'),
        ];
    }
}
