<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    public function run(): void
    {
        // Créer 50 livres
        $books = Book::factory()
            ->count(50)
            ->create();

        // Associer chaque livre à 1-3 catégories aléatoires
        $categories = Category::all();

        $books->each(function ($book) use ($categories) {
            $book->categories()->attach(
                $categories->random(rand(1, 3))->pluck('id')->toArray()
            );
        });
    }
}
