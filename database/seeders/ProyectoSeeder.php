<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProyectoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $proyecto  = \App\Models\Proyecto::create([
            'nombre' => 'Jóvenes con propósito',
            'active_at' => now(),
        ]);

        $proyecto->paises()->attach([1], ['active_at' => now()]);

        //Asignar un proyecto a un pais (Guatemala - Jóvenes con proposíto)
        // \App\Models\Pais::find(1)->proyectos()->attach(1, ['active_at' => now()]);

        $proyecto  = \App\Models\Proyecto::create([
            'nombre' => 'Jóvenes Líderes de Impacto por Centroamérica',
            'active_at' => now(),
        ]);

        //\App\Models\Pais::find(1)->proyectos()->attach([1, 2, 3], ['active_at' => now()]);

        $proyecto->paises()->attach([1, 3], ['active_at' => now()]);
    }
}
