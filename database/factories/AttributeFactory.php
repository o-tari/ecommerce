<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Attribute>
 */
class AttributeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'attribute_name' => $this->faker->unique()->word(),
            'created_by' => User::factory(),
            'updated_by' => null,
        ];
    }

    /**
     * Create an attribute with a specific name.
     */
    public function withName(string $name): static
    {
        return $this->state(fn (array $attributes) => [
            'attribute_name' => $name,
        ]);
    }

    /**
     * Create an attribute created by a specific user.
     */
    public function createdBy(User $user): static
    {
        return $this->state(fn (array $attributes) => [
            'created_by' => $user->id,
        ]);
    }

    /**
     * Create an attribute updated by a specific user.
     */
    public function updatedBy(User $user): static
    {
        return $this->state(fn (array $attributes) => [
            'updated_by' => $user->id,
        ]);
    }
}
