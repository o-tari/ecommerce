<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;

class OrdersChart extends ChartWidget
{
    protected static ?string $heading = 'Orders Over Time';

    protected function getData(): array
    {
        $days = collect();
        $orderCounts = collect();
        $revenue = collect();

        for ($i = 29; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $days->push($date->format('M d'));
            
            $dailyOrders = Order::whereDate('created_at', $date)->count();
            $orderCounts->push($dailyOrders);
            
            $dailyRevenue = Order::whereDate('created_at', $date)->sum('total_amount');
            $revenue->push($dailyRevenue);
        }

        return [
            'datasets' => [
                [
                    'label' => 'Orders',
                    'data' => $orderCounts->toArray(),
                    'borderColor' => '#3b82f6',
                    'backgroundColor' => 'rgba(59, 130, 246, 0.1)',
                    'yAxisID' => 'y',
                ],
                [
                    'label' => 'Revenue ($)',
                    'data' => $revenue->toArray(),
                    'borderColor' => '#10b981',
                    'backgroundColor' => 'rgba(16, 185, 129, 0.1)',
                    'yAxisID' => 'y1',
                ],
            ],
            'labels' => $days->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    protected function getOptions(): array
    {
        return [
            'scales' => [
                'y' => [
                    'type' => 'linear',
                    'display' => true,
                    'position' => 'left',
                    'title' => [
                        'display' => true,
                        'text' => 'Orders',
                    ],
                ],
                'y1' => [
                    'type' => 'linear',
                    'display' => true,
                    'position' => 'right',
                    'title' => [
                        'display' => true,
                        'text' => 'Revenue ($)',
                    ],
                    'grid' => [
                        'drawOnChartArea' => false,
                    ],
                ],
            ],
        ];
    }
}
