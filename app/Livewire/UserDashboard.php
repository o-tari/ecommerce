<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;

class UserDashboard extends Component
{
    public $statistics = [];
    public $loading = true;
    public $error = null;

    public function mount()
    {
        $this->fetchStatistics();
    }

    public function fetchStatistics()
    {
        $this->loading = true;
        $this->error = null;

        try {
            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'Authorization' => 'Bearer ' . Auth::user()->createToken('dashboard-token')->plainTextToken,
            ])->get(route('user.dashboard.statistics')); // Assuming a named route 'user.dashboard.statistics'

            if ($response->successful()) {
                $this->statistics = $response->json();
            } else {
                $this->error = 'Failed to fetch statistics: ' . $response->status();
                $this->statistics = $this->getDefaultStatistics();
            }
        } catch (\Exception $e) {
            $this->error = 'An error occurred: ' . $e->getMessage();
            $this->statistics = $this->getDefaultStatistics();
        } finally {
            $this->loading = false;
        }
    }

    private function getDefaultStatistics()
    {
        return [
            'total_orders_placed' => 'No info',
            'total_amount_spent' => '0.00',
            'average_order_value' => '0.00',
            'orders_last_30_days' => 'No info',
            'active_orders' => [],
            'available_coupons' => [],
            'top_purchased_items' => [],
            'returned_orders_count' => 'No info',
        ];
    }

    public function render()
    {
        return view('livewire.user-dashboard');
    }
}
