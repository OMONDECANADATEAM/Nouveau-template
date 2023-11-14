<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User; // Assurez-vous d'importer le modèle User
use Illuminate\Support\Str; // Assurez-vous d'importer la classe Str

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create a specific user
        User::factory()->create([
            'name' => 'Test User',
            'last_name' => 'Test Last Name',
            'email' => 'test@example.com',
            'email_verified_at' => now(),
            'password' => bcrypt('password'), // Utilisez bcrypt pour hacher le mot de passe
            'remember_token' => Str::random(10),
            'id_poste_occupe' => '1',
        'id_role_utilisateur' =>  '1' , 
               'id_succursale' => '1',
        ]);
    }
}
