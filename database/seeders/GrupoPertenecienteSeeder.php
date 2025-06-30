<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GrupoPertenecienteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $grupoPerteneciente = [
            'Indígena',
            'Afrodescendiente',
            'Mestizo/ladino',
            'Otros',
            'Ningún grupo',
            'No sabe',
            'Prefiere no contestar',
        ];

        foreach ($grupoPerteneciente as $grupoPerteneciente) {
            $grupo = \App\Models\GrupoPerteneciente::create([
                'nombre' => $grupoPerteneciente,
                'slug' => \Illuminate\Support\Str::slug($grupoPerteneciente),
                'active_at' => now(),
            ]);

            $grupo->paises()->syncWithoutDetaching([
                1 => ['active_at' => now()],
                2 => ['active_at' => now()],
                3 => ['active_at' => now()],
            ]);
        }
    }
}
