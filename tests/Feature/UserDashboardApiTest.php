<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Order;
use App\Models\Coupon;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\OrderStatus;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;
use Carbon\Carbon;

class UserDashboardApiTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();
        // Create an order status for 'delivered' and 'returned' for testing purposes
        OrderStatus::factory()->create(['status_name' => 'delivered']);
        OrderStatus::factory()->create(['status_name' => 'returned']);
        OrderStatus::factory()->create(['status_name' => 'pending']);
    }

    /** @test */
    public function it_returns_dashboard_statistics_for_authenticated_user()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        // Create some orders for the user
        $order1 = Order::factory()->create(['user_id' => $user->id, 'total_amount' => 100.50, 'order_status_id' => OrderStatus::where('status_name', 'delivered')->first()->id]);
        $order2 = Order::factory()->create(['user_id' => $user->id, 'total_amount' => 50.00, 'order_status_id' => OrderStatus::where('status_name', 'pending')->first()->id, 'created_at' => Carbon::now()->subDays(15)]);
        $order3 = Order::factory()->create(['user_id' => $user->id, 'total_amount' => 200.00, 'order_status_id' => OrderStatus::where('status_name', 'returned')->first()->id]);

        // Create order items and products
        $productA = Product::factory()->create(['product_name' => 'Product A']);
        $productB = Product::factory()->create(['product_name' => 'Product B']);
        $productC = Product::factory()->create(['product_name' => 'Product C']);

        OrderItem::factory()->create(['order_id' => $order1->id, 'product_id' => $productA->id, 'quantity' => 2]);
        OrderItem::factory()->create(['order_id' => $order1->id, 'product_id' => $productB->id, 'quantity' => 1]);
        OrderItem::factory()->create(['order_id' => $order2->id, 'product_id' => $productA->id, 'quantity' => 1]);
        OrderItem::factory()->create(['order_id' => $order2->id, 'product_id' => $productC->id, 'quantity' => 3]);
        OrderItem::factory()->create(['order_id' => $order3->id, 'product_id' => $productA->id, 'quantity' => 5]);

        // Create some coupons
        Coupon::factory()->create(['coupon_end_date' => Carbon::now()->addDays(7), 'coupon_start_date' => Carbon::now()->subDays(7), 'code' => 'SAVE10', 'discount_value' => 10, 'discount_type' => 'percentage']);
        Coupon::factory()->create(['coupon_end_date' => Carbon::now()->addDays(30), 'coupon_start_date' => Carbon::now()->subDays(10), 'code' => 'FREESHIP', 'discount_value' => 5, 'discount_type' => 'fixed']);

        $response = $this->getJson(route('user.dashboard.statistics'));

        $response->assertOk()
                 ->assertJsonStructure([
                     'total_orders_placed',
                     'total_amount_spent',
                     'average_order_value',
                     'orders_last_30_days',
                     'active_orders' => [
                         '*' => [
                             'order_number',
                             'total_amount',
                             'status',
                             'estimated_delivery_date',
                             'created_at',
                         ]
                     ],
                     'available_coupons' => [
                         '*' => [
                             'code',
                             'discount',
                             'expires_on',
                         ]
                     ],
                     'top_purchased_items' => [
                         '*' => [
                             'product_name',
                             'total_quantity',
                             'image_url',
                         ]
                     ],
                     'returned_orders_count',
                 ])
                 ->assertJson([ // Assert specific values for verification
                     'total_orders_placed' => 3,
                     'total_amount_spent' => '350.50',
                     'average_order_value' => '116.83',
                     'orders_last_30_days' => 3, // order1 and order2 are within 30 days
                     'returned_orders_count' => 1,
                 ]);

        // Assert active orders content
        $response->assertJsonFragment([
            'order_number' => $order2->order_number,
            'total_amount' => '50.00',
            'status' => 'pending',
        ]);

        // Assert coupons content
        $response->assertJsonFragment([
            'code' => 'SAVE10',
            'discount' => '10.00%',
        ]);

        // Assert top purchased items content
        $response->assertJsonFragment([
            'product_name' => 'Product A',
            'total_quantity' => 8,
        ]);
    }

    /** @test */
    public function it_returns_default_values_when_no_statistics_are_available()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $response = $this->getJson(route('user.dashboard.statistics'));

        $response->assertOk()
                 ->assertJson([ // Assert specific values for verification
                     'total_orders_placed' => 0,
                     'total_amount_spent' => '0.00',
                     'average_order_value' => '0.00',
                     'orders_last_30_days' => 0,
                     'active_orders' => [],
                     'available_coupons' => [],
                     'top_purchased_items' => [],
                     'returned_orders_count' => 0,
                 ]);
    }

    /** @test */
    public function unauthenticated_user_cannot_access_dashboard_statistics()
    {
        $response = $this->getJson(route('user.dashboard.statistics'));

        $response->assertUnauthorized();
    }
}
