<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Attribute;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductAttribute>
 */
class ProductAttributeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'product_id' => Product::factory(),
            'attribute_id' => Attribute::factory(),
        ];
    }

    /**
     * Create a product attribute for a specific product.
     */
    public function forProduct(Product $product): static
    {
        return $this->state(fn (array $attributes) => [
            'product_id' => $product->id,
        ]);
    }

    /**
     * Create a product attribute for a specific attribute.
     */
    public function forAttribute(Attribute $attribute): static
    {
        return $this->state(fn (array $attributes) => [
            'attribute_id' => $attribute->id,
        ]);
    }
}

