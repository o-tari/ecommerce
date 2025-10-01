<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use App\Livewire\UserDashboard;
use Tests\TestCase;
use Illuminate\Support\Facades\Http; // Import Http facade

class UserDashboardEmptyStatsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
    }

    /** @test */
    public function dashboard_displays_no_info_for_empty_statistics()
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $this->actingAs($user);

        // Mock the HTTP response for the dashboard statistics API
        Http::fake([
            route('user.dashboard.statistics') => Http::response([
                'total_orders_placed' => 0,
                'total_amount_spent' => '0.00',
                'average_order_value' => '0.00',
                'orders_last_30_days' => 0,
                'active_orders' => [],
                'available_coupons' => [],
                'top_purchased_items' => [],
                'returned_orders_count' => 0,
            ], 200),
        ]);

        Livewire::test(UserDashboard::class)
            ->assertSee('0')
            ->assertSee('$0.00')
            ->assertSee('No active orders.')
            ->assertSee('No coupons available.')
            ->assertSee('No purchase history yet.');
    }
}