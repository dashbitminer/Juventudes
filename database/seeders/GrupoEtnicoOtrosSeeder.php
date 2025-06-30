<?php

namespace Database\Seeders;

use App\Models\ComunidadEtnica;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GrupoEtnicoOtrosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $gruposEtnicos = [
            'Otros', //1
            // 'ladino / Metizo', //2
            // 'Maya', //3
            // 'Xinca', //4
            // 'Indigena', //5
            // 'Afrodescendiente', //6
            // 'Ninguno',
            // 'No sabe',
            // 'Prefiere no contestar',
        ];

        foreach ($gruposEtnicos as $grupoEtnico) {
            \App\Models\GrupoEtnico::create([
                'nombre' => $grupoEtnico,
                'active_at' => now(),
         //       'slug' => \Illuminate\Support\Str::slug($grupoEtnico),
            ]);
        }

        //Guatemala
        \App\Models\Pais::find(1)->grupoEtnico()->attach([7]);

        // Honduras
        \App\Models\Pais::find(3)->grupoEtnico()->attach([ 7 ]);

        ComunidadEtnica::create([
            'nombre' => 'Ninguno',
            'active_at' => now(),
            'grupo_etnico_id' => 7
        ]);
        ComunidadEtnica::create([
            'nombre' => 'No sabe',
            'active_at' => now(),
            'grupo_etnico_id' => 7
        ]);
        ComunidadEtnica::create([
            'nombre' => 'Prefiere no contestar',
            'active_at' => now(),
            'grupo_etnico_id' => 7
        ]);
    }
}
