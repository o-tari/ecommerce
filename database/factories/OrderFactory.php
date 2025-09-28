<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Order;
use App\Models\OrderStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Order::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $subtotal = $this->faker->randomFloat(2, 10, 1000);
        $taxAmount = $subtotal * 0.1; // 10% tax
        $shippingAmount = $this->faker->randomFloat(2, 5, 50);
        $discountAmount = $this->faker->randomFloat(2, 0, $subtotal * 0.2); // 0-20% discount
        $totalAmount = $subtotal + $taxAmount + $shippingAmount - $discountAmount;

        return [
            'id' => $this->faker->unique()->regexify('ORD-[0-9]{8}'),
            'order_number' => $this->faker->unique()->regexify('ORD-[0-9]{8}'),
            'coupon_id' => null,
            'user_id' => User::factory(),
            'order_status_id' => OrderStatus::factory(),
            'subtotal' => $subtotal,
            'tax_amount' => $taxAmount,
            'shipping_amount' => $shippingAmount,
            'discount_amount' => $discountAmount,
            'total_amount' => $totalAmount,
            'shipping_address' => $this->faker->address(),
            'billing_address' => $this->faker->address(),
            'notes' => $this->faker->optional()->sentence(),
            'payment_method' => $this->faker->randomElement(['credit_card', 'paypal', 'bank_transfer']),
            'payment_status' => $this->faker->randomElement(['pending', 'paid', 'failed']),
            'shipping_method' => $this->faker->randomElement(['standard', 'express', 'overnight']),
            'tracking_number' => $this->faker->optional()->regexify('[A-Z]{2}[0-9]{9}[A-Z]{2}'),
            'shipping_address_id' => null,
            'billing_address_id' => null,
            'order_approved_at' => $this->faker->optional()->dateTimeBetween('-1 year', 'now'),
            'order_delivered_carrier_date' => $this->faker->optional()->dateTimeBetween('-1 year', 'now'),
            'order_delivered_customer_date' => $this->faker->optional()->dateTimeBetween('-1 year', 'now'),
            'created_by' => \App\Models\User::factory(),
            'updated_by' => \App\Models\User::factory(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    /**
     * Create an order with a specific status.
     */
    public function withStatus(OrderStatus $status): static
    {
        return $this->state(fn (array $attributes) => [
            'order_status_id' => $status->id,
        ]);
    }

    /**
     * Create an approved order.
     */
    public function approved(): static
    {
        return $this->state(fn (array $attributes) => [
            'order_approved_at' => now(),
        ]);
    }

    /**
     * Create a delivered order.
     */
    public function delivered(): static
    {
        return $this->state(fn (array $attributes) => [
            'order_delivered_carrier_date' => now(),
            'order_delivered_customer_date' => now(),
        ]);
    }
}
