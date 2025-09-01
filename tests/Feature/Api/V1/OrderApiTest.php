<?php

namespace Tests\Feature\Api\V1;

use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\Customer;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderApiTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;
    protected string $token;
    protected Customer $customer;
    protected OrderStatus $orderStatus;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->user = User::factory()->create();
        $this->token = $this->user->createToken('test-token')->plainTextToken;
        $this->customer = Customer::factory()->create();
        $this->orderStatus = OrderStatus::factory()->create();
    }

    public function test_can_list_orders(): void
    {
        Order::factory()->count(3)->create([
            'customer_id' => $this->customer->id,
            'order_status_id' => $this->orderStatus->id,
            'created_by' => $this->user->id,
            'updated_by' => $this->user->id,
        ]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
            'Accept' => 'application/json',
        ])->getJson('/api/v1/orders');

        $response->assertStatus(200)
                ->assertJsonStructure([
                    'success',
                    'message',
                    'data' => [
                        'current_page',
                        'data' => [
                            '*' => [
                                'id',
                                'order_number',
                                'customer_id',
                                'order_status_id',
                                'subtotal',
                                'total_amount',
                                'created_at',
                                'updated_at'
                            ]
                        ],
                        'total',
                        'per_page'
                    ]
                ])
                ->assertJson([
                    'success' => true,
                    'message' => 'Orders retrieved successfully'
                ]);

        $this->assertEquals(3, $response->json('data.total'));
    }

    public function test_can_filter_orders_by_status(): void
    {
        $status1 = OrderStatus::factory()->create();
        $status2 = OrderStatus::factory()->create();

        Order::factory()->create([
            'order_status_id' => $status1->id,
            'customer_id' => $this->customer->id,
            'created_by' => $this->user->id,
            'updated_by' => $this->user->id,
        ]);
        
        Order::factory()->create([
            'order_status_id' => $status2->id,
            'customer_id' => $this->customer->id,
            'created_by' => $this->user->id,
            'updated_by' => $this->user->id,
        ]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
            'Accept' => 'application/json',
        ])->getJson('/api/v1/orders?order_status_id=' . $status1->id);

        $response->assertStatus(200);
        $this->assertEquals(1, $response->json('data.total'));
        $this->assertEquals($status1->id, $response->json('data.data.0.order_status_id'));
    }

    public function test_can_filter_orders_by_customer(): void
    {
        $customer2 = Customer::factory()->create();

        Order::factory()->create([
            'customer_id' => $this->customer->id,
            'order_status_id' => $this->orderStatus->id,
            'created_by' => $this->user->id,
            'updated_by' => $this->user->id,
        ]);
        
        Order::factory()->create([
            'customer_id' => $customer2->id,
            'order_status_id' => $this->orderStatus->id,
            'created_by' => $this->user->id,
            'updated_by' => $this->user->id,
        ]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
            'Accept' => 'application/json',
        ])->getJson('/api/v1/orders?customer_id=' . $this->customer->id);

        $response->assertStatus(200);
        $this->assertEquals(1, $response->json('data.total'));
        $this->assertEquals($this->customer->id, $response->json('data.data.0.customer_id'));
    }

    public function test_can_search_orders(): void
    {
        Order::factory()->create([
            'order_number' => 'ORD-SPECIAL-001',
            'customer_id' => $this->customer->id,
            'order_status_id' => $this->orderStatus->id,
            'created_by' => $this->user->id,
            'updated_by' => $this->user->id,
        ]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
            'Accept' => 'application/json',
        ])->getJson('/api/v1/orders?search=SPECIAL');

        $response->assertStatus(200);
        $this->assertEquals(1, $response->json('data.total'));
        $this->assertStringContainsString('SPECIAL', $response->json('data.data.0.order_number'));
    }

    public function test_can_get_single_order(): void
    {
        $order = Order::factory()->create([
            'customer_id' => $this->customer->id,
            'order_status_id' => $this->orderStatus->id,
            'created_by' => $this->user->id,
            'updated_by' => $this->user->id,
        ]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
            'Accept' => 'application/json',
        ])->getJson('/api/v1/orders/' . $order->id);

        $response->assertStatus(200)
                ->assertJsonStructure([
                    'success',
                    'message',
                    'data' => [
                        'id',
                        'order_number',
                        'customer_id',
                        'order_status_id',
                        'subtotal',
                        'total_amount',
                        'created_at',
                        'updated_at'
                    ]
                ])
                ->assertJson([
                    'success' => true,
                    'message' => 'Order retrieved successfully',
                    'data' => [
                        'id' => $order->id,
                        'order_number' => $order->order_number,
                        'customer_id' => $order->customer_id,
                    ]
                ]);
    }

    public function test_can_create_order(): void
    {
        $orderData = [
            'order_number' => 'ORD-001',
            'customer_id' => $this->customer->id,
            'order_status_id' => $this->orderStatus->id,
            'subtotal' => 84.01,
            'total_amount' => 99.99,
            'tax_amount' => 9.99,
            'shipping_amount' => 5.99,
            'notes' => 'Test order notes',
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])->postJson('/api/v1/orders', $orderData);

        $response->assertStatus(201)
                ->assertJsonStructure([
                    'success',
                    'message',
                    'data' => [
                        'id',
                        'order_number',
                        'customer_id',
                        'order_status_id',
                        'subtotal',
                        'total_amount',
                        'tax_amount',
                        'shipping_amount',
                        'notes',
                        'created_at',
                        'updated_at'
                    ]
                ])
                ->assertJson([
                    'success' => true,
                    'message' => 'Order created successfully',
                    'data' => [
                        'order_number' => 'ORD-001',
                        'customer_id' => $this->customer->id,
                        'order_status_id' => $this->orderStatus->id,
                        'subtotal' => '84.01',
                        'total_amount' => '99.99',
                        'tax_amount' => '9.99',
                        'shipping_amount' => '5.99',
                        'notes' => 'Test order notes',
                    ]
                ]);

        $this->assertDatabaseHas('orders', [
            'order_number' => 'ORD-001',
            'customer_id' => $this->customer->id,
            'created_by' => $this->user->id,
            'updated_by' => $this->user->id,
        ]);
    }

    public function test_cannot_create_order_with_invalid_data(): void
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])->postJson('/api/v1/orders', [
            'order_number' => '',
            'customer_id' => 999999,
            'order_status_id' => 999999,
            'subtotal' => 'invalid-amount',
            'total_amount' => 'invalid-amount',
        ]);

        $response->assertStatus(422)
                ->assertJsonValidationErrors([
                    'order_number',
                    'customer_id',
                    'order_status_id',
                    'subtotal',
                    'total_amount'
                ]);
    }

    public function test_cannot_create_order_with_existing_order_number(): void
    {
        Order::factory()->create([
            'order_number' => 'ORD-EXISTING',
            'customer_id' => $this->customer->id,
            'order_status_id' => $this->orderStatus->id,
            'created_by' => $this->user->id,
            'updated_by' => $this->user->id,
        ]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])->postJson('/api/v1/orders', [
            'order_number' => 'ORD-EXISTING',
            'customer_id' => $this->customer->id,
            'order_status_id' => $this->orderStatus->id,
            'subtotal' => 84.01,
            'total_amount' => 99.99,
        ]);

        $response->assertStatus(422)
                ->assertJsonValidationErrors(['order_number']);
    }

    public function test_can_update_order(): void
    {
        $order = Order::factory()->create([
            'customer_id' => $this->customer->id,
            'order_status_id' => $this->orderStatus->id,
            'created_by' => $this->user->id,
            'updated_by' => $this->user->id,
        ]);

        $newStatus = OrderStatus::factory()->create();

        $updateData = [
            'order_status_id' => $newStatus->id,
            'notes' => 'Updated order notes',
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])->putJson('/api/v1/orders/' . $order->id, $updateData);

        $response->assertStatus(200)
                ->assertJson([
                    'success' => true,
                    'message' => 'Order updated successfully',
                    'data' => [
                        'order_status_id' => $newStatus->id,
                        'notes' => 'Updated order notes',
                    ]
                ]);

        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'order_status_id' => $newStatus->id,
            'notes' => 'Updated order notes',
            'updated_by' => $this->user->id,
        ]);
    }

    public function test_can_delete_order(): void
    {
        $order = Order::factory()->create([
            'customer_id' => $this->customer->id,
            'order_status_id' => $this->orderStatus->id,
            'created_by' => $this->user->id,
            'updated_by' => $this->user->id,
        ]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
            'Accept' => 'application/json',
        ])->deleteJson('/api/v1/orders/' . $order->id);

        $response->assertStatus(200)
                ->assertJson([
                    'success' => true,
                    'message' => 'Order deleted successfully'
                ]);

        $this->assertDatabaseMissing('orders', [
            'id' => $order->id,
        ]);
    }

    public function test_cannot_delete_order_with_items(): void
    {
        $order = Order::factory()->create([
            'customer_id' => $this->customer->id,
            'order_status_id' => $this->orderStatus->id,
            'created_by' => $this->user->id,
            'updated_by' => $this->user->id,
        ]);

        // Create order item
        $product = Product::factory()->create();
        $order->orderItems()->create([
            'product_id' => $product->id,
            'quantity' => 1,
            'price' => 29.99,
        ]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
            'Accept' => 'application/json',
        ])->deleteJson('/api/v1/orders/' . $order->id);

        $response->assertStatus(409)
                ->assertJson([
                    'success' => false,
                    'message' => 'Cannot delete order with items'
                ]);

        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
        ]);
    }

    public function test_unauthenticated_user_cannot_access_orders(): void
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->getJson('/api/v1/orders');

        $response->assertStatus(401);
    }

    public function test_can_paginate_orders(): void
    {
        Order::factory()->count(25)->create([
            'customer_id' => $this->customer->id,
            'order_status_id' => $this->orderStatus->id,
            'created_by' => $this->user->id,
            'updated_by' => $this->user->id,
        ]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
            'Accept' => 'application/json',
        ])->getJson('/api/v1/orders?per_page=10&page=2');

        $response->assertStatus(200);
        $this->assertEquals(10, count($response->json('data.data')));
        $this->assertEquals(2, $response->json('data.current_page'));
        $this->assertEquals(25, $response->json('data.total'));
    }

    public function test_can_sort_orders(): void
    {
        Order::factory()->create([
            'order_number' => 'A-ORDER',
            'customer_id' => $this->customer->id,
            'order_status_id' => $this->orderStatus->id,
            'created_by' => $this->user->id,
            'updated_by' => $this->user->id,
        ]);
        
        Order::factory()->create([
            'order_number' => 'Z-ORDER',
            'customer_id' => $this->customer->id,
            'order_status_id' => $this->orderStatus->id,
            'created_by' => $this->user->id,
            'updated_by' => $this->user->id,
        ]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
            'Accept' => 'application/json',
        ])->getJson('/api/v1/orders?sort_by=order_number&sort_direction=asc');

        $response->assertStatus(200);
        $this->assertEquals('A-ORDER', $response->json('data.data.0.order_number'));
        $this->assertEquals('Z-ORDER', $response->json('data.data.1.order_number'));
    }
}
