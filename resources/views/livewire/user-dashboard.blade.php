<div class="p-6 bg-white shadow-md rounded-lg">
    <h2 class="text-2xl font-semibold mb-6 text-gray-800">Your Dashboard</h2>

    @if ($loading)
        <div class="text-center py-8">
            <p class="text-gray-600">Loading statistics...</p>
            {{-- You can add a spinner here if you have one --}}
        </div>
    @elseif ($error)
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
            <strong class="font-bold">Error!</strong>
            <span class="block sm:inline">{{ $error }}</span>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            <div class="bg-blue-50 p-4 rounded-lg shadow-sm">
                <h3 class="text-lg font-medium text-blue-800">Total Orders</h3>
                <p class="text-3xl font-bold text-blue-600">{{ $statistics['total_orders_placed'] ?? 'No info' }}</p>
            </div>
            <div class="bg-green-50 p-4 rounded-lg shadow-sm">
                <h3 class="text-lg font-medium text-green-800">Total Spent</h3>
                <p class="text-3xl font-bold text-green-600">${{ $statistics['total_amount_spent'] ?? '0.00' }}</p>
            </div>
            <div class="bg-yellow-50 p-4 rounded-lg shadow-sm">
                <h3 class="text-lg font-medium text-yellow-800">Avg. Order Value</h3>
                <p class="text-3xl font-bold text-yellow-600">${{ $statistics['average_order_value'] ?? '0.00' }}</p>
            </div>
            <div class="bg-purple-50 p-4 rounded-lg shadow-sm">
                <h3 class="text-lg font-medium text-purple-800">Orders Last 30 Days</h3>
                <p class="text-3xl font-bold text-purple-600">{{ $statistics['orders_last_30_days'] ?? 'No info' }}</p>
            </div>
            <div class="bg-red-50 p-4 rounded-lg shadow-sm">
                <h3 class="text-lg font-medium text-red-800">Returned Orders</h3>
                <p class="text-3xl font-bold text-red-600">{{ $statistics['returned_orders_count'] ?? 'No info' }}</p>
            </div>
        </div>

        <div class="mb-8">
            <h3 class="text-xl font-semibold mb-4 text-gray-800">Active Orders</h3>
            @if (empty($statistics['active_orders']))
                <p class="text-gray-600">No active orders.</p>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white border border-gray-200 rounded-lg">
                        <thead>
                            <tr class="bg-gray-100 text-left text-gray-600 uppercase text-sm leading-normal">
                                <th class="py-3 px-6">Order #</th>
                                <th class="py-3 px-6">Amount</th>
                                <th class="py-3 px-6">Status</th>
                                <th class="py-3 px-6">Est. Delivery</th>
                                <th class="py-3 px-6">Ordered On</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-700 text-sm font-light">
                            @foreach ($statistics['active_orders'] as $order)
                                <tr class="border-b border-gray-200 hover:bg-gray-50">
                                    <td class="py-3 px-6 whitespace-nowrap">{{ $order['order_number'] }}</td>
                                    <td class="py-3 px-6">${{ $order['total_amount'] }}</td>
                                    <td class="py-3 px-6">{{ $order['status'] }}</td>
                                    <td class="py-3 px-6">{{ $order['estimated_delivery_date'] }}</td>
                                    <td class="py-3 px-6">{{ $order['created_at'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

        <div class="mb-8">
            <h3 class="text-xl font-semibold mb-4 text-gray-800">Available Coupons</h3>
            @if (empty($statistics['available_coupons']))
                <p class="text-gray-600">No coupons available.</p>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach ($statistics['available_coupons'] as $coupon)
                        <div class="bg-gray-50 border border-dashed border-gray-300 p-4 rounded-lg flex justify-between items-center">
                            <div>
                                <p class="text-lg font-semibold text-gray-800">{{ $coupon['code'] }}</p>
                                <p class="text-sm text-gray-600">Discount: {{ $coupon['discount'] }}</p>
                            </div>
                            <p class="text-sm text-gray-500">Expires: {{ $coupon['expires_on'] }}</p>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <div>
            <h3 class="text-xl font-semibold mb-4 text-gray-800">Your Top Purchased Items</h3>
            @if (empty($statistics['top_purchased_items']))
                <p class="text-gray-600">No purchase history yet.</p>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($statistics['top_purchased_items'] as $item)
                        <div class="bg-gray-50 p-4 rounded-lg shadow-sm flex items-center space-x-4">
                            @if ($item['image_url'])
                                <img src="{{ $item['image_url'] }}" alt="{{ $item['product_name'] }}" class="w-16 h-16 object-cover rounded-md">
                            @else
                                <div class="w-16 h-16 bg-gray-200 rounded-md flex items-center justify-center text-gray-500 text-xs">No Image</div>
                            @endif
                            <div>
                                <p class="font-medium text-gray-800">{{ $item['product_name'] }}</p>
                                <p class="text-sm text-gray-600">Purchased: {{ $item['total_quantity'] }} times</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    @endif
</div>
