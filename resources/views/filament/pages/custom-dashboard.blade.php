<x-filament-panels::page>
    <div class="space-y-6">
        {{-- Header Widgets --}}
        @if ($this->getHeaderWidgets())
            <div class="grid grid-cols-1 gap-4 lg:grid-cols-2 xl:grid-cols-3">
                @foreach ($this->getHeaderWidgets() as $widget)
                    @livewire($widget)
                @endforeach
            </div>
        @endif

        {{-- Main Content Area --}}
        <div class="space-y-6">
            {{-- Charts Row --}}
            <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
                {{-- Orders Chart Widget --}}
                @if (in_array(OrdersChart::class, $this->getFooterWidgets()))
                    <div class="lg:col-span-1">
                        @livewire(OrdersChart::class)
                    </div>
                @endif

                {{-- Revenue Chart Widget --}}
                @if (in_array(RevenueChart::class, $this->getFooterWidgets()))
                    <div class="lg:col-span-1">
                        @livewire(RevenueChart::class)
                    </div>
                @endif
            </div>

            {{-- Customer Growth Chart --}}
            @if (in_array(CustomerGrowth::class, $this->getFooterWidgets()))
                <div class="w-full">
                    @livewire(CustomerGrowth::class)
                </div>
            @endif

            {{-- Tables Row --}}
            <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
                {{-- Latest Orders Widget --}}
                @if (in_array(LatestOrders::class, $this->getFooterWidgets()))
                    <div class="lg:col-span-1">
                        @livewire(LatestOrders::class)
                    </div>
                @endif

                {{-- Top Products Widget --}}
                @if (in_array(TopProducts::class, $this->getFooterWidgets()))
                    <div class="lg:col-span-1">
                        @livewire(TopProducts::class)
                    </div>
                @endif
            </div>

            {{-- Recent Activity Widget --}}
            @if (in_array(RecentActivity::class, $this->getFooterWidgets()))
                <div class="w-full">
                    @livewire(RecentActivity::class)
                </div>
            @endif
        </div>

        {{-- Additional Dashboard Content --}}
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Quick Actions</h3>
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
                <a href="{{ route('filament.admin.resources.products.create') }}" 
                   class="flex items-center p-4 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors">
                    <div class="flex-shrink-0">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-blue-900">Add Product</p>
                        <p class="text-xs text-blue-700">Create new product</p>
                    </div>
                </a>

                <a href="{{ route('filament.admin.resources.orders.index') }}" 
                   class="flex items-center p-4 bg-green-50 rounded-lg hover:bg-green-100 transition-colors">
                    <div class="flex-shrink-0">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-green-900">View Orders</p>
                        <p class="text-xs text-green-700">Manage customer orders</p>
                    </div>
                </a>

                <a href="{{ route('filament.admin.resources.customers.index') }}" 
                   class="flex items-center p-4 bg-purple-50 rounded-lg hover:bg-purple-100 transition-colors">
                    <div class="flex-shrink-0">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-purple-900">Customers</p>
                        <p class="text-xs text-purple-700">Manage customers</p>
                    </div>
                </a>

                <a href="{{ route('filament.admin.resources.categories.index') }}" 
                   class="flex items-center p-4 bg-orange-50 rounded-lg hover:bg-orange-100 transition-colors">
                    <div class="flex-shrink-0">
                        <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-orange-900">Categories</p>
                        <p class="text-xs text-orange-700">Organize products</p>
                    </div>
                </a>
            </div>
        </div>
    </div>
</x-filament-panels::page>
