<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AreaFormacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $areas = [
            'Ciencias Sociales',
            'Humanidades',
            'Artes y Bellas Artes',
            'Ingeniería y Tecnología',
            'Ciencias de la Salud',
            'Ciencias de la Educación',
            'Negocios y Administración',
            'Ciencias Ambientales',
            'Ciencias de la Comunicación',
            'Tecnología de la Información',
            'Emprendimiento y Negocios',
            'Ciencias del Deporte',
            'Educación básica, secundaria o bachillerato',
            'Educación universitaria',
            'Educación Técnica',
        ];

        foreach ($areas as $area) {
            $record = \App\Models\AreaFormacion::create([
                'nombre' => $area,
                'active_at' => now(),
            ]);

            $record->pais()->attach([1,2,3], ['active_at' => now()]);
        }
    }
}
