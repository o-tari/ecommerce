<?php

namespace Database\Factories;

use App\Models\OrderStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrderStatus>
 */
class OrderStatusFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = OrderStatus::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'status_name' => $this->faker->randomElement(['Pending', 'Processing', 'Shipped', 'Delivered', 'Cancelled']),
            'color' => $this->faker->hexColor(),
            'privacy' => $this->faker->randomElement(['public', 'private']),
            'created_by' => \App\Models\User::factory(),
            'updated_by' => \App\Models\User::factory(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    /**
     * Create a pending order status.
     */
    public function pending(): static
    {
        return $this->state(fn (array $attributes) => [
            'status_name' => 'Pending',
            'color' => '#FFA500',
        ]);
    }

    /**
     * Create a processing order status.
     */
    public function processing(): static
    {
        return $this->state(fn (array $attributes) => [
            'status_name' => 'Processing',
            'color' => '#0000FF',
        ]);
    }

    /**
     * Create a shipped order status.
     */
    public function shipped(): static
    {
        return $this->state(fn (array $attributes) => [
            'status_name' => 'Shipped',
            'color' => '#800080',
        ]);
    }

    /**
     * Create a delivered order status.
     */
    public function delivered(): static
    {
        return $this->state(fn (array $attributes) => [
            'status_name' => 'Delivered',
            'color' => '#008000',
        ]);
    }

    /**
     * Create a cancelled order status.
     */
    public function cancelled(): static
    {
        return $this->state(fn (array $attributes) => [
            'status_name' => 'Cancelled',
            'color' => '#FF0000',
        ]);
    }
}
