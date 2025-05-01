<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
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

        foreach ($mainCategories as $categoryName) {
            Category::firstOrCreate(['category' => $categoryName]);
        }

        if (app()->environment('local')) {
            Category::factory()
                ->count(10)
                ->create();
        }
    }
}
