<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected static ?string $password;
    public static int $clientCounter = 1; // Changé de private à public static

    public function definition(): array
    {
        return [
            'first_name' => 'Client' . self::$clientCounter,
            'last_name' => 'User' . self::$clientCounter,
            'address' => $this->faker->streetAddress(),
            'date_birth' => $this->faker->dateTimeBetween('-70 years', '-18 years')->format('Y-m-d'),
            'city' => $this->faker->city(),
            'code_postal' => $this->faker->postcode(),
            'telephone' => $this->faker->phoneNumber(),
            'role' => 'Client',
            'status' => $this->faker->randomElement(['Suspendu', 'Active']),
            'email' => 'client' . self::$clientCounter++ . '@gmail.com',
            'photo' => 'profiles/EaJ1arAoeRZNPq5mVOSD3D00uWS7y8TGAQ8Rss28.png',
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('Password123$'),
            'remember_token' => Str::random(10),
        ];
    }

    public function librarian(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'Bibliothécaire',
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'email' => $this->faker->unique()->safeEmail(),
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
