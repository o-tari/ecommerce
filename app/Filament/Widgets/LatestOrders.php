<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestOrders extends BaseWidget
{
    protected static ?int $sort = 3;
    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Order::query()
                    ->latest()
                    ->limit(10)
            )
            ->columns([
                Tables\Columns\TextColumn::make('order_number')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('User')
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
            ])
            ->actions([
                Tables\Actions\Action::make('view')
                    ->url(fn (Order $record): string => route('filament.admin.resources.orders.edit', $record))
                    ->icon('heroicon-m-eye')
                    ->label('View Order'),
            ]);
    }
}
