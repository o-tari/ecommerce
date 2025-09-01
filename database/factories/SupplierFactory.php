<?php

namespace Database\Factories;

use App\Models\Country;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Supplier>
 */
class SupplierFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'supplier_name' => $this->faker->company(),
            'company' => $this->faker->optional()->company(),
            'phone_number' => $this->faker->optional()->phoneNumber(),
            'address_line1' => $this->faker->streetAddress(),
            'address_line2' => $this->faker->optional()->secondaryAddress(),
            'country_id' => Country::factory(),
            'city' => $this->faker->optional()->city(),
            'note' => $this->faker->optional()->sentence(),
            'created_by' => User::factory(),
            'updated_by' => null,
        ];
    }

    /**
     * Create a supplier with a specific name.
     */
    public function withName(string $name): static
    {
        return $this->state(fn (array $attributes) => [
            'supplier_name' => $name,
        ]);
    }

    /**
     * Create a supplier with a company.
     */
    public function withCompany(string $company): static
    {
        return $this->state(fn (array $attributes) => [
            'company' => $company,
        ]);
    }

    /**
     * Create a supplier with a phone number.
     */
    public function withPhone(string $phone): static
    {
        return $this->state(fn (array $attributes) => [
            'phone_number' => $phone,
        ]);
    }

    /**
     * Create a supplier for a specific country.
     */
    public function forCountry(Country $country): static
    {
        return $this->state(fn (array $attributes) => [
            'country_id' => $country->id,
        ]);
    }

    /**
     * Create a supplier created by a specific user.
     */
    public function createdBy(User $user): static
    {
        return $this->state(fn (array $attributes) => [
            'created_by' => $user->id,
        ]);
    }

    /**
     * Create a supplier updated by a specific user.
     */
    public function updatedBy(User $user): static
    {
        return $this->state(fn (array $attributes) => [
            'updated_by' => $user->id,
        ]);
    }
}
