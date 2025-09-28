<?php

namespace App\Filament\Widgets;

use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\Supplier;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Products', Product::count())
                ->description('Products in catalog')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),

            Stat::make('Total Users', User::count())
                ->description('Registered users')
                ->descriptionIcon('heroicon-m-users')
                ->color('info'),

            Stat::make('Total Orders', Order::count())
                ->description('Orders placed')
                ->descriptionIcon('heroicon-m-shopping-cart')
                ->color('warning'),

            Stat::make('Total Suppliers', Supplier::count())
                ->description('Active suppliers')
                ->descriptionIcon('heroicon-m-building-office')
                ->color('primary'),

            Stat::make('Revenue This Month', '$' . number_format(Order::whereMonth('created_at', now()->month)->sum('total_amount'), 2))
                ->description('Monthly revenue')
                ->descriptionIcon('heroicon-m-currency-dollar')
                ->color('success'),

            Stat::make('Active Products', Product::where('published', true)->count())
                ->description('Published products')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),
        ];
    }
}
