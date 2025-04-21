<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        // Catégories principales fixes
        $mainCategories = [
            'Roman',
            'Policier',
            'Science-Fiction',
            'Fantasy',
            'Biographie',
            'Histoire',
            'Scolaire',
            'Jeunesse',
            'BD-Manga',
            'Art'
        ];

        // Création des catégories principales avec la factory
        foreach ($mainCategories as $categoryName) {
            Category::factory()->create([
                'category' => $categoryName,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Génération de catégories supplémentaires aléatoires en environnement local
        if (app()->environment('local')) {
            Category::factory()
                ->count(10) // Nombre de catégories supplémentaires
                ->create();
        }
    }
}
