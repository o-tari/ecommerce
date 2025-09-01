<?php

namespace App\Filament\Widgets;

use App\Models\Customer;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;

class CustomerGrowth extends ChartWidget
{
    protected static ?string $heading = 'Customer Growth';
    protected static ?int $sort = 6;
    protected int|string|array $columnSpan = 'full';

    protected function getData(): array
    {
        $months = collect();
        $newCustomers = collect();
        $totalCustomers = collect();

        for ($i = 11; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $months->push($date->format('M Y'));
            
            $monthlyNewCustomers = Customer::whereYear('registered_at', $date->year)
                ->whereMonth('registered_at', $date->month)
                ->count();
            $newCustomers->push($monthlyNewCustomers);
            
            $monthlyTotalCustomers = Customer::where('registered_at', '<=', $date->endOfMonth())->count();
            $totalCustomers->push($monthlyTotalCustomers);
        }

        return [
            'datasets' => [
                [
                    'label' => 'New Customers',
                    'data' => $newCustomers->toArray(),
                    'borderColor' => '#8b5cf6',
                    'backgroundColor' => 'rgba(139, 92, 246, 0.1)',
                    'yAxisID' => 'y',
                    'type' => 'bar',
                ],
                [
                    'label' => 'Total Customers',
                    'data' => $totalCustomers->toArray(),
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
                        'text' => 'New Customers',
                    ],
                ],
                'y1' => [
                    'type' => 'linear',
                    'display' => true,
                    'position' => 'right',
                    'title' => [
                        'display' => true,
                        'text' => 'Total Customers',
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
