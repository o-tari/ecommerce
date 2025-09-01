<x-filament-panels::page>
    <div class="space-y-6">
        {{-- Report Form --}}
        <div class="bg-white rounded-lg shadow p-6">
            <form wire:submit="generateReport">
                {{ $this->form }}
            </form>
        </div>

        {{-- Report Results --}}
        @if(!empty($reportData))
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">
                    {{ ucwords(str_replace('_', ' ', $reportData['type'])) }} Report
                    <span class="text-sm font-normal text-gray-500">({{ $reportData['period'] ?? '' }})</span>
                </h3>

                @switch($reportData['type'])
                    @case('sales_summary')
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                            <div class="bg-blue-50 p-4 rounded-lg">
                                <div class="text-2xl font-bold text-blue-600">{{ $reportData['total_orders'] }}</div>
                                <div class="text-sm text-blue-800">Total Orders</div>
                            </div>
                            <div class="bg-green-50 p-4 rounded-lg">
                                <div class="text-2xl font-bold text-green-600">${{ number_format($reportData['total_revenue'], 2) }}</div>
                                <div class="text-sm text-green-800">Total Revenue</div>
                            </div>
                            <div class="bg-purple-50 p-4 rounded-lg">
                                <div class="text-2xl font-bold text-purple-600">${{ number_format($reportData['avg_order_value'], 2) }}</div>
                                <div class="text-sm text-purple-800">Avg Order Value</div>
                            </div>
                            <div class="bg-orange-50 p-4 rounded-lg">
                                <div class="text-2xl font-bold text-orange-600">{{ count($reportData['daily_breakdown']) }}</div>
                                <div class="text-sm text-orange-800">Active Days</div>
                            </div>
                        </div>

                        @if(!empty($reportData['daily_breakdown']))
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Orders</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Revenue</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Avg Order</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($reportData['daily_breakdown'] as $date => $data)
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $date }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $data['orders'] }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${{ number_format($data['revenue'], 2) }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${{ number_format($data['avg_order_value'], 2) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                        @break

                    @case('product_performance')
                        @if(!empty($reportData['products']))
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">SKU</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Orders</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Revenue</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stock</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($reportData['products'] as $product)
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $product['name'] }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $product['sku'] }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $product['orders'] }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${{ number_format($product['revenue'], 2) }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $product['stock'] }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                        @break

                    @case('customer_analysis')
                        @if(!empty($reportData['customers']))
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Orders</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Spent</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Avg Order</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($reportData['customers'] as $customer)
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $customer['name'] }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $customer['email'] }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $customer['orders'] }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${{ number_format($customer['total_spent'], 2) }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${{ number_format($customer['avg_order_value'], 2) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                        @break

                    @case('category_breakdown')
                        @if(!empty($reportData['categories']))
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Products Sold</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Revenue</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($reportData['categories'] as $category)
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $category['name'] }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $category['products_sold'] }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${{ number_format($category['revenue'], 2) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                        @break

                    @case('inventory_status')
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                            <div class="bg-blue-50 p-4 rounded-lg">
                                <div class="text-2xl font-bold text-blue-600">{{ $reportData['total_products'] }}</div>
                                <div class="text-sm text-blue-800">Total Products</div>
                            </div>
                            <div class="bg-green-50 p-4 rounded-lg">
                                <div class="text-2xl font-bold text-green-600">{{ $reportData['published_products'] }}</div>
                                <div class="text-sm text-green-800">Published</div>
                            </div>
                            <div class="bg-yellow-50 p-4 rounded-lg">
                                <div class="text-2xl font-bold text-yellow-600">{{ $reportData['low_stock_products'] }}</div>
                                <div class="text-sm text-yellow-800">Low Stock</div>
                            </div>
                            <div class="bg-red-50 p-4 rounded-lg">
                                <div class="text-2xl font-bold text-red-600">{{ $reportData['out_of_stock_products'] }}</div>
                                <div class="text-sm text-red-800">Out of Stock</div>
                            </div>
                        </div>

                        @if(!empty($reportData['stock_breakdown']))
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stock Status</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Count</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($reportData['stock_breakdown'] as $status => $count)
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $status }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $count }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                        @break

                    @default
                        <div class="text-center py-8">
                            <p class="text-gray-500">No report data available</p>
                        </div>
                @endswitch
            </div>
        @endif
    </div>
</x-filament-panels::page>
