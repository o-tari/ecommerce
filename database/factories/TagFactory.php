<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tag>
 */
class TagFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $tagName = $this->faker->unique()->word();
        
        return [
            'tag_name' => $tagName,
            'icon' => $this->faker->optional()->randomElement(['🏷️', '🏷', '📌', '🔖', '⭐']),
            'created_by' => User::factory(),
            'updated_by' => null,
        ];
    }

    /**
     * Create a tag with a specific name.
     */
    public function withName(string $name): static
    {
        return $this->state(fn (array $attributes) => [
            'tag_name' => $name,
        ]);
    }

    /**
     * Create a tag with an icon.
     */
    public function withIcon(string $icon): static
    {
        return $this->state(fn (array $attributes) => [
            'icon' => $icon,
        ]);
    }

    /**
     * Create a tag created by a specific user.
     */
    public function createdBy(User $user): static
    {
        return $this->state(fn (array $attributes) => [
            'created_by' => $user->id,
        ]);
    }

    /**
     * Create a tag updated by a specific user.
     */
    public function updatedBy(User $user): static
    {
        return $this->state(fn (array $attributes) => [
            'updated_by' => $user->id,
        ]);
    }
}
