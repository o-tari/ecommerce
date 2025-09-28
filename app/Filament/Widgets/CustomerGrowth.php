<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;

class CustomerGrowth extends ChartWidget
{
    protected static ?string $heading = 'User Growth';
    protected static ?int $sort = 6;
    protected int|string|array $columnSpan = 'full';

    protected function getData(): array
    {
        $months = collect();
        $newUsers = collect();
        $totalUsers = collect();

        for ($i = 11; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $months->push($date->format('M Y'));
            
            $monthlyNewUsers = User::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
            $newUsers->push($monthlyNewUsers);
            
            $monthlyTotalUsers = User::where('created_at', '<=', $date->endOfMonth())->count();
            $totalUsers->push($monthlyTotalUsers);
        }

        return [
            'datasets' => [
                [
                    'label' => 'New Users',
                    'data' => $newUsers->toArray(),
                    'borderColor' => '#8b5cf6',
                    'backgroundColor' => 'rgba(139, 92, 246, 0.1)',
                    'yAxisID' => 'y',
                    'type' => 'bar',
                ],
                [
                    'label' => 'Total Users',
                    'data' => $totalUsers->toArray(),
                    'borderColor' => '#f59e0b',
                    'backgroundColor' => 'rgba(245, 158, 11, 0.1)',
                    'yAxisID' => 'y1',
                    'type' => 'line',
                ],
            ],
            'labels' => $months->toArray(),
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
                        'text' => 'New Users',
                    ],
                ],
                'y1' => [
                    'type' => 'linear',
                    'display' => true,
                    'position' => 'right',
                    'title' => [
                        'display' => true,
                        'text' => 'Total Users',
                    ],
                    'grid' => [
                        'drawOnChartArea' => false,
                    ],
                ],
            ],
            'plugins' => [
                'legend' => [
                    'display' => true,
                    'position' => 'top',
                ],
            ],
        ];
    }
}
