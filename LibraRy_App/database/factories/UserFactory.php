<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected static ?string $password;

    public function definition(): array
    {
        return [
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'address' => $this->faker->streetAddress(),
            'date_birth' => $this->faker->dateTimeBetween('-70 years', '-18 years')->format('Y-m-d'),
            'city' => $this->faker->city(),
            'code_postal' => $this->faker->postcode(),
            'telephone' => $this->faker->phoneNumber(),
            'role' => $this->faker->randomElement(['Bibliothécaire', 'Client']),
            'status' => $this->faker->randomElement(['Suspendu', 'Active']),
            'email' => $this->faker->unique()->safeEmail(),
            'photo' => null, // ou $this->faker->imageUrl(200, 200, 'people')
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
        ];
    }

    public function librarian(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'Bibliothécaire',
        ]);
    }

    public function client(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'Client',
        ]);
    }

    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'Active',
        ]);
    }

    public function suspended(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'Suspendu',
        ]);
    }

    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
