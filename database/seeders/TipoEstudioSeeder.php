<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TipoEstudioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $opciones = [
            'Educación básica',
            'Formación Técnico',
            'Estudio Universitario',
            'Curso',
            'Diplomado',
            'Otro',
        ];

        foreach ($opciones as $opcion) {
            $record = \App\Models\TipoEstudio::create([
                'nombre' => $opcion,
                'active_at' => now(),
            ]);

            $record->pais()->attach([1,2,3], ['active_at' => now()]);
        }
    }
}
