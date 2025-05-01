<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    public function definition(): array
    {
        $libraryCategories = [
            'Roman', 'Policier', 'Science-Fiction', 'Fantasy', 'Biographie',
            'Histoire', 'Scolaire', 'Jeunesse', 'Poésie', 'Théâtre',
            'BD-Manga', 'Art', 'Cuisine', 'Voyage', 'Développement Personnel',
            'Science', 'Technologie', 'Économie', 'Philosophie', 'Religion'
        ];

        return [
            'category' => $this->faker->unique()->randomElement($libraryCategories),
            'created_at' => $this->faker->dateTimeBetween('-2 years', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }
}
