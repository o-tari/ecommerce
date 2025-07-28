<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\ProductShippingInfo;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $productName = $this->faker->sentence(3);
        $salePrice = $this->faker->randomFloat(2, 1, 1000);
        $comparePrice = $salePrice * $this->faker->randomFloat(0.8, 1.0, 1.2);
        if ($comparePrice < $salePrice) {
            $comparePrice = $salePrice;
        }

        return [
            'slug' => Str::slug($productName),
            'product_name' => $productName,
            'sku' => $this->faker->optional()->text(5),
            'sale_price' => $salePrice,
            'compare_price' => $comparePrice,
            'buying_price' => $this->faker->optional()->randomFloat(2, 1, $salePrice * 0.8),
            'quantity' => $this->faker->numberBetween(0, 1000),
            'short_description' => $this->faker->text(165),
            'product_description' => $this->faker->paragraphs(3, true),
            'published' => $this->faker->boolean(70), // 70% chance of being published
            'disable_out_of_stock' => $this->faker->boolean(80), // 80% chance of being disabled out of stock
            'note' => $this->faker->optional()->text,
            'created_by' => User::factory()->create()->id,
            'updated_by' => User::factory()->create()->id,
        ];
    }

    public function configure(): static
    {
        return $this->afterCreating(function (\App\Models\Product $product) {
            // Create 1 to 3 categories and attach them to the product
            $categories = Category::factory()->count(rand(1, 3))->create();
            $product->categories()->attach($categories->pluck('id'));
            ProductShippingInfo::factory()->create(['product_id' => $product->id]);
        });
    }
}
