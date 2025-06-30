<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NivelEducativoFormacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $opciones = [
            '1°',
            '2°',
            '3°',
            '4°',
            '5°',
            '6°',
            '7°',
            '8°',
            '9°',
            '1° año de bachillerato',
            '2° año de bachillerato',
            '3° año de bachillerato',
        ];

        foreach ($opciones as $opcion) {
            $record = \App\Models\NivelEducativoFormacion::create([
                'nombre' => $opcion,
                'active_at' => now(),
            ]);

            $record->pais()->attach([1,2,3], ['active_at' => now()]);
        }
    }
}
