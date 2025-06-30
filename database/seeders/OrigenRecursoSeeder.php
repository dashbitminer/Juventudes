<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrigenRecursoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tipos = [
            'Basado en el país',
            'Basado en EE.UU',
            'Basado en un tercer país',
            'Otros'
        ];

        foreach ($tipos as $tipo) {
            \App\Models\OrigenRecurso::create([
                'nombre' => $tipo,
                'active_at' => now(),
            ]);
        }

        \App\Models\OrigenRecurso::all()->each(function ($tipoAlianza) {
            $tipoAlianza->pais()->attach([1,2,3], ['active_at' => now()]);
        });
    }
}
