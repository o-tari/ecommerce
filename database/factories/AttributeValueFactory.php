<?php

namespace Database\Factories;

use App\Models\Attribute;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AttributeValue>
 */
class AttributeValueFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'attribute_id' => Attribute::factory(),
            'attribute_value' => $this->faker->word(),
            'color' => $this->faker->optional()->hexColor(),
        ];
    }

    /**
     * Create an attribute value with a specific value.
     */
    public function withValue(string $value): static
    {
        return $this->state(fn (array $attributes) => [
            'attribute_value' => $value,
        ]);
    }

    /**
     * Create an attribute value with a specific color.
     */
    public function withColor(string $color): static
    {
        return $this->state(fn (array $attributes) => [
            'color' => $color,
        ]);
    }

    /**
     * Create an attribute value for a specific attribute.
     */
    public function forAttribute(Attribute $attribute): static
    {
        return $this->state(fn (array $attributes) => [
            'attribute_id' => $attribute->id,
        ]);
    }
}
