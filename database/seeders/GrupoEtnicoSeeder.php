<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GrupoEtnicoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $gruposEtnicos = [
            'Garifuna', //1
            'ladino / Metizo', //2
            'Maya', //3
            'Xinca', //4
            'Indigena', //5
            'Afrodescendiente', //6
            'Ninguno',
            'No sabe',
            'Prefiere no contestar',
        ];

        foreach ($gruposEtnicos as $grupoEtnico) {
            \App\Models\GrupoEtnico::create([
                'nombre' => $grupoEtnico,
                'active_at' => now(),
         //       'slug' => \Illuminate\Support\Str::slug($grupoEtnico),
            ]);
        }

        //Guatemala
        \App\Models\Pais::find(1)->grupoEtnico()->attach([1, 2, 3, 4]);

        // Honduras
        \App\Models\Pais::find(3)->grupoEtnico()->attach([ 2, 5, 6]);

    }
}
