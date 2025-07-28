<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'parent_id' => Category::factory()->withoutParent(), // Allows for nullable parent, randomly creates a parent if not null
            'category_name' => $this->faker->unique()->word(),
            'category_description' => $this->faker->text(200), // Limit description length for realism
//            'icon' => $this->faker->randomElement(['fas fa-folder', 'fas fa-tag', 'fas fa-cubes', 'fas fa-box', 'fas fa-list']), // Example font awesome icons
//            'image' => $this->faker->imageUrl(640, 480, 'categories', true), // Realistic image URL
            'placeholder' => $this->faker->word, // Placeholder text
            'active' => $this->faker->boolean(85), // 85% chance of being active
            'created_by' => User::factory(), // Allows for nullable creator, randomly creates a staff account if not null
            'updated_by' => User::factory(), // Allows for nullable updater, randomly creates a staff account if not null
        ];
    }

    /**
     * Configure the factory to create categories without a parent.
     *
     * @return \Database\Factories\CategoryFactory
     */
    public function withoutParent(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'parent_id' => null,
            ];
        });
    }

    /**
     * Configure the factory to create categories with a specific parent.
     *
     * @param Category $parent
     * @return \Database\Factories\CategoryFactory
     */
    public function forParent(Category $parent): static
    {
        return $this->state(function (array $attributes) use ($parent) {
            return [
                'parent_id' => $parent->id,
            ];
        });
    }

    /**
     * Configure the factory to create categories without a creator.
     *
     * @return \Database\Factories\CategoryFactory
     */
    public function withoutCreator(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'created_by' => null,
            ];
        });
    }

    /**
     * Configure the factory to create categories with a specific creator.
     *
     * @param User $user
     * @return \Database\Factories\CategoryFactory
     */
    public function createdBy(User $user): static
    {
        return $this->state(function (array $attributes) use ($user) {
            return [
                'created_by' => $user->id,
            ];
        });
    }

    /**
     * Configure the factory to create categories without an updater.
     *
     * @return \Database\Factories\CategoryFactory
     */
    public function withoutUpdater(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'updated_by' => null,
            ];
        });
    }

    /**
     * Configure the factory to create categories with a specific updater.
     *
     * @param User $user
     * @return \Database\Factories\CategoryFactory
     */
    public function updatedBy(User $user): static
    {
        return $this->state(function (array $attributes) use ($user) {
            return [
                'updated_by' => $user->id,
            ];
        });
    }
}
