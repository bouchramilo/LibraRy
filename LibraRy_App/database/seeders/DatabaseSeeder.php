<?php
namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        $this->call([
            CategorySeeder::class,
            BookSeeder::class,
            UserSeeder::class,
        ]);

        // DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}


