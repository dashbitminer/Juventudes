<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TipoSectorPublicoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tipos = [
            'Gobierno Central',
            'Gobierno Local',
        ];

        foreach ($tipos as $tipo) {
            \App\Models\TipoSectorPublico::create([
                'nombre' => $tipo,
                'active_at' => now(),
            ]);
        }

        \App\Models\TipoSectorPublico::all()->each(function ($sectorPublico) {
            $sectorPublico->pais()->attach([1,2,3], ['active_at' => now()]);
        });
    }
}
