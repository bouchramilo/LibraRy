<?php

namespace Database\Seeders;

use App\Models\User;
use Database\Factories\UserFactory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Réinitialiser le compteur pour les clients
        UserFactory::$clientCounter = 1;

        // Admin principal
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

        // 5 bibliothécaires
        User::factory()
            ->count(0)
            ->librarian()
            ->active()
            ->create([
                'password' => Hash::make('Librarian123!'),
            ]);

        // 15 clients actifs
        User::factory()
            ->count(15)
            ->active()
            ->create();

        // 5 clients suspendus
        User::factory()
            ->count(5)
            ->suspended()
            ->create();

        // Client de test
        User::create([
            'first_name' => 'ClientTest',
            'last_name' => 'UserTest',
            'address' => '456 Rue Client',
            'date_birth' => '1995-05-15',
            'city' => 'Lyon',
            'code_postal' => '69000',
            'telephone' => '0698765432',
            'role' => 'Client',
            'status' => 'Active',
            'email' => 'client.test@gmail.com',
            'password' => Hash::make('Client123!'),
            'email_verified_at' => now(),
        ]);
    }
}
