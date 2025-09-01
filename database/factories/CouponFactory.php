<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Coupon>
 */
class CouponFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'code' => $this->faker->unique()->regexify('[A-Z0-9]{6,8}'),
            'discount_value' => $this->faker->randomFloat(2, 5, 100),
            'discount_type' => $this->faker->randomElement(['percentage', 'fixed']),
            'times_used' => 0,
            'max_usage' => $this->faker->optional()->numberBetween(10, 1000),
            'order_amount_limit' => $this->faker->optional()->randomFloat(2, 50, 500),
            'coupon_start_date' => $this->faker->optional()->dateTimeBetween('-1 month', '+1 month'),
            'coupon_end_date' => $this->faker->optional()->dateTimeBetween('+1 month', '+6 months'),
            'created_by' => User::factory(),
            'updated_by' => null,
        ];
    }

    /**
     * Create a percentage discount coupon.
     */
    public function percentage(): static
    {
        return $this->state(fn (array $attributes) => [
            'discount_type' => 'percentage',
            'discount_value' => $this->faker->numberBetween(5, 50),
        ]);
    }

    /**
     * Create a fixed amount discount coupon.
     */
    public function fixed(): static
    {
        return $this->state(fn (array $attributes) => [
            'discount_type' => 'fixed',
            'discount_value' => $this->faker->randomFloat(2, 5, 100),
        ]);
    }

    /**
     * Create a coupon with a specific code.
     */
    public function withCode(string $code): static
    {
        return $this->state(fn (array $attributes) => [
            'code' => $code,
        ]);
    }

    /**
     * Create a coupon with usage limits.
     */
    public function withUsageLimit(int $maxUsage): static
    {
        return $this->state(fn (array $attributes) => [
            'max_usage' => $maxUsage,
        ]);
    }

    /**
     * Create a coupon with order amount limit.
     */
    public function withOrderAmountLimit(float $limit): static
    {
        return $this->state(fn (array $attributes) => [
            'order_amount_limit' => $limit,
        ]);
    }

    /**
     * Create a coupon created by a specific user.
     */
    public function createdBy(User $user): static
    {
        return $this->state(fn (array $attributes) => [
            'created_by' => $user->id,
        ]);
    }

    /**
     * Create a coupon updated by a specific user.
     */
    public function updatedBy(User $user): static
    {
        return $this->state(fn (array $attributes) => [
            'updated_by' => $user->id,
        ]);
    }
}
