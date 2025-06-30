<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TipoRecursoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tipos = [
            'Efectivo',
            'En especie',
            'Garantía de préstamo',
            'Préstamo'
        ];

        foreach ($tipos as $tipo) {
            \App\Models\TipoRecurso::create([
                'nombre' => $tipo,
                'active_at' => now(),
            ]);
        }

        \App\Models\TipoRecurso::all()->each(function ($tipoAlianza) {
            $tipoAlianza->pais()->attach([1,2,3], ['active_at' => now()]);
        });
    }
}
