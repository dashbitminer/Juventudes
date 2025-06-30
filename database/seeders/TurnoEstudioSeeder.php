<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TurnoEstudioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $turno_estudio = [
            'Matutino-mañana',
            'Vespertino-tarde',
            'Nocturno-noche',
            'Jornada extendida-todo el día',
            'Modalidad Flexible',
            'Virtual',
        ];

        foreach ($turno_estudio as $turno_estudio) {
            \App\Models\TurnoEstudio::create([
                'nombre' => $turno_estudio,
                'slug' => \Illuminate\Support\Str::slug($turno_estudio),
                'active_at' => now(),
            ]);
        }
    }
}
