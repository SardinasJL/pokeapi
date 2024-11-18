<?php

namespace Database\Seeders;

use App\Models\Pokemon;
use App\Models\Tipo;
use App\Models\User;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::create(["name" => "admin", "email" => "admin@admin.com", "password" => "12345678"]);
        Tipo::insert([
            ["descripcion" => "eléctrico"], ["descripcion" => "fuego"], ["descripcion" => "agua"], ["descripcion" => "roca"]
        ]);
        Pokemon::insert([
            ["nombre" => "Pikachu", "peso" => 1.5, "altura" => 0.8, "foto" => "1.jpg", "tipos_id" => 1],
            ["nombre" => "Charizard", "peso" => 100, "altura" => 3, "foto" => "2.jpg", "tipos_id" => 2],
            ["nombre" => "Squirtle", "peso" => 2, "altura" => 0.8, "foto" => "3.jpg", "tipos_id" => 3],
            ["nombre" => "Onix", "peso" => 300, "altura" => 4, "foto" => "4.jpg", "tipos_id" => 4],
        ]);
    }

}
