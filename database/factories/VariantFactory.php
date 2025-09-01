<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Variant;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Variant>
 */
class VariantFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Variant::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'product_id' => Product::factory(),
            'variant_option' => $this->faker->sentence(),
            'variant_option_id' => \App\Models\VariantOption::factory()->create()->id,
            'sku' => $this->faker->unique()->regexify('[A-Z]{2}[0-9]{4}'),
            'price' => $this->faker->randomFloat(2, 1, 1000),
            'quantity' => $this->faker->numberBetween(0, 1000),
            'weight' => $this->faker->randomFloat(2, 0.1, 100),
            'is_active' => $this->faker->boolean(80),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    /**
     * Create a variant with a specific option.
     */
    public function withOption(string $option): static
    {
        return $this->state(fn (array $attributes) => [
            'variant_option' => $option,
        ]);
    }
}
