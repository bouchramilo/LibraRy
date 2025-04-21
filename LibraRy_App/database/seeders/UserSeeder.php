<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'first_name' => 'Admin',
            'last_name' => 'System',
            'address' => '123 Rue Admin',
            'date_birth' => '1981-02-01',
            'city' => 'Tanger',
            'code_postal' => '75000',
            'telephone' => '0612345678',
            'role' => 'Bibliothécaire',
            'status' => 'Active',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('Admin123$'),
            'email_verified_at' => now(),
        ]);

        // Créer 5 bibliothécaires
        User::factory()
            ->count(5)
            ->librarian()
            ->active()
            ->create([
                'password' => Hash::make('Librarian123!'),
            ]);

        // Créer 20 clients (dont certains suspendus)
        User::factory()
            ->count(15)
            ->client()
            ->active()
            ->create();

        User::factory()
            ->count(5)
            ->client()
            ->suspended()
            ->create();

        // Optionnel : créer un utilisateur de test facile à retenir
        User::create([
            'first_name' => 'Client',
            'last_name' => 'Test',
            'address' => '456 Rue Client',
            'date_birth' => '1995-05-15',
            'city' => 'Lyon',
            'code_postal' => '69000',
            'telephone' => '0698765432',
            'role' => 'Client',
            'status' => 'Active',
            'email' => 'client@test.com',
            'password' => Hash::make('Client123!'),
            'email_verified_at' => now(),
        ]);
    }
}
