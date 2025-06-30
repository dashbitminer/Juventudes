<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FuenteRecursoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tipos = [
            'Instituciones financieras',
            'Corporaciones',
            'Fundaciones',
            'Gobierno',
            'Otros'
        ];

        foreach ($tipos as $tipo) {
            \App\Models\FuenteRecurso::create([
                'nombre' => $tipo,
                'active_at' => now(),
            ]);
        }

        \App\Models\FuenteRecurso::all()->each(function ($tipoAlianza) {
            $tipoAlianza->pais()->attach([1,2,3], ['active_at' => now()]);
        });
    }
}
