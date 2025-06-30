<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CriterioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $criterios = ["Edad", "Nivel Educativo", "Medio de comparación constancia de estudios"];

        foreach ($criterios as $criterio) {
            \App\Models\Criterio::create([
                'nombre' => $criterio,
                'active_at' => now(),
            ]);
        }

    }
}
