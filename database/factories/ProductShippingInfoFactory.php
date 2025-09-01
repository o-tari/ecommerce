<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\ProductShippingInfo;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductShippingInfo>
 */
class ProductShippingInfoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ProductShippingInfo::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'product_id' => Product::factory(),
            'weight' => $this->faker->randomFloat(2, 0.1, 10),
            'weight_unit' => $this->faker->randomElement(['g', 'kg']),
            'volume' => $this->faker->randomFloat(2, 0.1, 100),
            'volume_unit' => $this->faker->randomElement(['l', 'ml']),
            'dimension_width' => $this->faker->randomFloat(2, 1, 100),
            'dimension_height' => $this->faker->randomFloat(2, 1, 100),
            'dimension_depth' => $this->faker->randomFloat(2, 1, 100),
            'dimension_unit' => $this->faker->randomElement(['cm', 'm']),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    /**
     * Create shipping info with metric units.
     */
    public function metric(): static
    {
        return $this->state(fn (array $attributes) => [
            'weight_unit' => 'kg',
            'volume_unit' => 'l',
            'dimension_unit' => 'cm',
        ]);
    }

    /**
     * Create shipping info with imperial units.
     */
    public function imperial(): static
    {
        return $this->state(fn (array $attributes) => [
            'weight_unit' => 'lb',
            'volume_unit' => 'gal',
            'dimension_unit' => 'in',
        ]);
    }
}
