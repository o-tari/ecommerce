<?php

namespace App\Filament\Pages;

use App\Models\Order;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Category;
use Filament\Pages\Page;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class Reports extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';
    protected static ?string $navigationGroup = 'Analytics';
    protected static ?string $title = 'Reports';
    protected static ?string $slug = 'reports';
    protected static ?int $navigationSort = 50;

    public ?array $data = [];
    public array $reportData = [];

    public function mount(): void
    {
        $this->form->fill([
            'report_type' => 'sales_summary',
            'start_date' => now()->subMonth()->format('Y-m-d'),
            'end_date' => now()->format('Y-m-d'),
            'category_id' => null,
        ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Report Parameters')
                    ->description('Select report type and date range')
                    ->schema([
                        Select::make('report_type')
                            ->label('Report Type')
                            ->options([
                                'sales_summary' => 'Sales Summary',
                                'product_performance' => 'Product Performance',
                                'customer_analysis' => 'Customer Analysis',
                                'category_breakdown' => 'Category Breakdown',
                                'inventory_status' => 'Inventory Status',
                            ])
                            ->required()
                            ->reactive(),
                        DatePicker::make('start_date')
                            ->label('Start Date')
                            ->required(),
                        DatePicker::make('end_date')
                            ->label('End Date')
                            ->required(),
                        Select::make('category_id')
                            ->label('Category (Optional)')
                            ->options(Category::pluck('category_name', 'id'))
                            ->searchable()
                            ->visible(fn ($get) => in_array($get('report_type'), ['product_performance', 'category_breakdown'])),
                    ])
                    ->columns(2),
            ]);
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('generate')
                ->label('Generate Report')
                ->action('generateReport')
                ->color('primary'),
            Action::make('export')
                ->label('Export Report')
                ->action('exportReport')
                ->color('success')
                ->visible(fn () => !empty($this->reportData)),
        ];
    }

    public function generateReport(): void
    {
        $data = $this->form->getState();
        $startDate = Carbon::parse($data['start_date']);
        $endDate = Carbon::parse($data['end_date']);

        switch ($data['report_type']) {
            case 'sales_summary':
                $this->reportData = $this->generateSalesSummary($startDate, $endDate);
                break;
            case 'product_performance':
                $this->reportData = $this->generateProductPerformance($startDate, $endDate, $data['category_id']);
                break;
            case 'customer_analysis':
                $this->reportData = $this->generateCustomerAnalysis($startDate, $endDate);
                break;
            case 'category_breakdown':
                $this->reportData = $this->generateCategoryBreakdown($startDate, $endDate);
                break;
            case 'inventory_status':
                $this->reportData = $this->generateInventoryStatus();
                break;
        }

        Notification::make()
            ->title('Report generated successfully')
            ->success()
            ->send();
    }

    protected function generateSalesSummary($startDate, $endDate): array
    {
        $orders = Order::whereBetween('created_at', [$startDate, $endDate])->get();
        
        $dailySales = $orders->groupBy(function ($order) {
            return $order->created_at->format('Y-m-d');
        })->map(function ($dayOrders) {
            return [
                'orders' => $dayOrders->count(),
                'revenue' => $dayOrders->sum('total_amount'),
                'avg_order_value' => $dayOrders->avg('total_amount'),
            ];
        });

        return [
            'type' => 'sales_summary',
            'period' => $startDate->format('M d, Y') . ' - ' . $endDate->format('M d, Y'),
            'total_orders' => $orders->count(),
            'total_revenue' => $orders->sum('total_amount'),
            'avg_order_value' => $orders->avg('total_amount'),
            'daily_breakdown' => $dailySales,
        ];
    }

    protected function generateProductPerformance($startDate, $endDate, $categoryId = null): array
    {
        $query = Product::withCount(['orderItems' => function ($query) use ($startDate, $endDate) {
            $query->whereHas('order', function ($q) use ($startDate, $endDate) {
                $q->whereBetween('created_at', [$startDate, $endDate]);
            });
        }]);

        if ($categoryId) {
            $query->whereHas('categories', function ($q) use ($categoryId) {
                $q->where('categories.id', $categoryId);
            });
        }

        $products = $query->orderBy('order_items_count', 'desc')->limit(20)->get();

        return [
            'type' => 'product_performance',
            'period' => $startDate->format('M d, Y') . ' - ' . $endDate->format('M d, Y'),
            'products' => $products->map(function ($product) {
                return [
                    'name' => $product->product_name,
                    'sku' => $product->sku,
                    'orders' => $product->order_items_count,
                    'revenue' => $product->orderItems->sum('total_price'),
                    'stock' => $product->quantity,
                ];
            }),
        ];
    }

    protected function generateCustomerAnalysis($startDate, $endDate): array
    {
        $customers = Customer::withCount(['orders' => function ($query) use ($startDate, $endDate) {
            $query->whereBetween('created_at', [$startDate, $endDate]);
        }])->withSum(['orders' => function ($query) use ($startDate, $endDate) {
            $query->whereBetween('created_at', [$startDate, $endDate]);
        }], 'total_amount')->orderBy('orders_sum_total_amount', 'desc')->limit(20)->get();

        return [
            'type' => 'customer_analysis',
            'period' => $startDate->format('M d, Y') . ' - ' . $endDate->format('M d, Y'),
            'customers' => $customers->map(function ($customer) {
                return [
                    'name' => $customer->first_name . ' ' . $customer->last_name,
                    'email' => $customer->email,
                    'orders' => $customer->orders_count,
                    'total_spent' => $customer->orders_sum_total_amount ?? 0,
                    'avg_order_value' => $customer->orders_count > 0 ? ($customer->orders_sum_total_amount ?? 0) / $customer->orders_count : 0,
                ];
            }),
        ];
    }

    protected function generateCategoryBreakdown($startDate, $endDate): array
    {
        $categories = Category::withCount(['products' => function ($query) use ($startDate, $endDate) {
            $query->whereHas('orderItems.order', function ($q) use ($startDate, $endDate) {
                $q->whereBetween('created_at', [$startDate, $endDate]);
            });
        }])->withSum(['products.orderItems' => function ($query) use ($startDate, $endDate) {
            $query->whereHas('order', function ($q) use ($startDate, $endDate) {
                $q->whereBetween('created_at', [$startDate, $endDate]);
            });
        }], 'total_price')->orderBy('products_sum_total_price', 'desc')->get();

        return [
            'type' => 'category_breakdown',
            'period' => $startDate->format('M d, Y') . ' - ' . $endDate->format('M d, Y'),
            'categories' => $categories->map(function ($category) {
                return [
                    'name' => $category->category_name,
                    'products_sold' => $category->products_count,
                    'revenue' => $category->products_sum_total_price ?? 0,
                ];
            }),
        ];
    }

    protected function generateInventoryStatus(): array
    {
        $products = Product::select('quantity', 'published')
            ->selectRaw('CASE WHEN quantity <= 10 THEN "Low Stock" WHEN quantity = 0 THEN "Out of Stock" ELSE "In Stock" END as stock_status')
            ->get();

        $stockBreakdown = $products->groupBy('stock_status')->map->count();

        return [
            'type' => 'inventory_status',
            'total_products' => $products->count(),
            'published_products' => $products->where('published', true)->count(),
            'stock_breakdown' => $stockBreakdown,
            'low_stock_products' => Product::where('quantity', '<=', 10)->where('quantity', '>', 0)->count(),
            'out_of_stock_products' => Product::where('quantity', 0)->count(),
        ];
    }

    public function exportReport(): void
    {
        // Here you would implement CSV/Excel export functionality
        Notification::make()
            ->title('Export functionality coming soon')
            ->info()
            ->send();
    }

    protected function getViewData(): array
    {
        return [
            'reportData' => $this->reportData,
        ];
    }
}
