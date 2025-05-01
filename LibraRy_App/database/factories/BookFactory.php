<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class BookFactory extends Factory
{
    public function definition(): array
    {
        $languages = ['Français', 'Anglais', 'Arabe', 'Espagnol'];

        return [
            'title' => $this->faker->sentence(3),
            'author' => $this->faker->name,
            'resume' => $this->faker->paragraphs(3, true),
            'photo' => 'book_covers/0aIHHPwfcTGvO6NncAWZd2vqeVOMI7Icw1tIcz7k.png',
            'nbr_pages' => $this->faker->numberBetween(50, 800),
            'date_edition' => $this->faker->dateTimeBetween('-10 years', 'now')->format('Y-m-d'),
            'isbn' => $this->faker->unique()->isbn13,
            'language' => $this->faker->randomElement($languages),
            'prix_emprunte' => $this->faker->randomFloat(2, 5, 50),
            // 'prix_vente' => $this->faker->randomFloat(2, 20, 200),
        ];
    }
}
