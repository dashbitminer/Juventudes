<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MedioVerificacionVoluntarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $opciones = [
            'Carta de voluntariado emitida por la organización o institución.',
        ];

        foreach ($opciones as $opcion) {
            $record = \App\Models\MedioVerificacionVoluntario::create([
                'nombre' => $opcion,
                'active_at' => now(),
            ]);

            $record->pais()->attach([1, 2, 3], ['active_at' => now()]);
        }
    }
}
