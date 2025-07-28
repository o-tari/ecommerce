<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductShippingInfo>
 */
class ProductShippingInfoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'product_id' => null, // Will be set by a relationship or can be overridden
            'weight' => $this->faker->randomFloat(2, 0.1, 5000),
            'weight_unit' => $this->faker->randomElement(['g', 'kg']),
            'volume' => $this->faker->randomFloat(2, 0.1, 100),
            'volume_unit' => $this->faker->randomElement(['l', 'ml']),
            'dimension_width' => $this->faker->randomFloat(2, 1, 100),
            'dimension_height' => $this->faker->randomFloat(2, 1, 100),
            'dimension_depth' => $this->faker->randomFloat(2, 1, 100),
            'dimension_unit' => $this->faker->randomElement(['cm', 'm']), // Assuming 'cm' and 'm' for dimensions based on common usage
        ];
    }
}
