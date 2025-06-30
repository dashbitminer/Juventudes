<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FuenteIngresoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fuentes = [
            ['nombre' => 'Empleos formales'],
            ['nombre' => 'Empleos informales'],
            ['nombre' => 'Negocios propios'],
            ['nombre' => 'Prestamos'],
            ['nombre' => 'Remesas'],
            ['nombre' => 'Ayuda gubernamental'],
            ['nombre' => 'Otros'],
        ];

        foreach ($fuentes as $fuente) {
            \App\Models\FuenteIngreso::create([
                'nombre' => $fuente['nombre'],
                'slug' => \Illuminate\Support\Str::slug($fuente['nombre']),
                'active_at' => now(),
            ]);
        }
    }
}
