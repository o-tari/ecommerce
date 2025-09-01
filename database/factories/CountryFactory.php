<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Country>
 */
class CountryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'iso' => $this->faker->unique()->countryCode(),
            'name' => $this->faker->unique()->country(),
            'upper_name' => strtoupper($this->faker->country()),
            'iso3' => $this->faker->unique()->regexify('[A-Z]{3}'),
            'num_code' => $this->faker->unique()->numberBetween(1, 999),
            'phone_code' => '+' . $this->faker->numberBetween(1, 999),
        ];
    }

    /**
     * Create a country with a specific ISO code.
     */
    public function withIso(string $iso): static
    {
        return $this->state(fn (array $attributes) => [
            'iso' => $iso,
        ]);
    }

    /**
     * Create a country with a specific name.
     */
    public function withName(string $name): static
    {
        return $this->state(fn (array $attributes) => [
            'name' => $name,
            'upper_name' => strtoupper($name),
        ]);
    }

    /**
     * Create a country with a specific phone code.
     */
    public function withPhoneCode(string $phoneCode): static
    {
        return $this->state(fn (array $attributes) => [
            'phone_code' => $phoneCode,
        ]);
    }
}

