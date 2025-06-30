<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CohorteProyectoUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (User::all() as $user) {
            $user->cohorte()->attach(1,[
                'rol' => fake()->randomElement(['gestor', 'coordinador']),
                //'socios_implementador_id' => fake()->randomElement([1, 2, 3]),
                // Para pruebas en sesiones establecer todos para Glasswing
                //'socios_implementador_id' => 1,
            ]);
        }
    }
}
