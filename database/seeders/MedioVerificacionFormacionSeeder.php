<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MedioVerificacionFormacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $opciones = [
            'Certificado de inscripción',
            'Certificado de graduación',
            'Constancia de formación',
        ];

        foreach ($opciones as $opcion) {
            $record = \App\Models\MedioVerificacionFormacion::create([
                'nombre' => $opcion,
                'active_at' => now(),
            ]);

            $record->pais()->attach([1,2,3], ['active_at' => now()]);
        }
    }
}
