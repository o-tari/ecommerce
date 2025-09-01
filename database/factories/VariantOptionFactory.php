<?php

namespace Database\Factories;

use App\Models\Variant;
use App\Models\VariantOption;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\VariantOption>
 */
class VariantOptionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = VariantOption::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'product_id' => \App\Models\Product::factory(),
            'title' => $this->faker->randomElement(['Color', 'Size', 'Material', 'Style']),
            'sale_price' => $this->faker->randomFloat(2, 10, 1000),
            'compare_price' => $this->faker->randomFloat(2, 15, 1200),
            'buying_price' => $this->faker->optional()->randomFloat(2, 5, 800),
            'quantity' => $this->faker->numberBetween(0, 1000),
            'sku' => $this->faker->optional()->regexify('[A-Z]{2}[0-9]{6}'),
            'active' => $this->faker->boolean(80),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    /**
     * Create a color option.
     */
    public function color(): static
    {
        return $this->state(fn (array $attributes) => [
            'title' => 'Color',
        ]);
    }

    /**
     * Create a size option.
     */
    public function size(): static
    {
        return $this->state(fn (array $attributes) => [
            'title' => 'Size',
        ]);
    }
}
