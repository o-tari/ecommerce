<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\LatestOrders;
use App\Filament\Widgets\OrdersChart;
use App\Filament\Widgets\StatsOverview;
use App\Filament\Widgets\TopProducts;
use App\Filament\Widgets\RevenueChart;
use App\Filament\Widgets\RecentActivity;
use Filament\Pages\Page;

class Dashboard extends \Filament\Pages\Dashboard
{
    protected static ?string $navigationIcon = 'heroicon-o-home';

    protected static string $view = 'filament.pages.dashboard';
    protected static ?string $slug = 'dashboard';
    protected static ?string $title = 'Dashboard';
    protected static ?int $navigationSort = 1;

    protected function getHeaderWidgets(): array
    {
        return [
            StatsOverview::class,
        ];
    }

    protected function getFooterWidgets(): array
    {
        return [
            OrdersChart::class,
            RevenueChart::class,
            LatestOrders::class,
            TopProducts::class,
            RecentActivity::class,
        ];
    }
}
