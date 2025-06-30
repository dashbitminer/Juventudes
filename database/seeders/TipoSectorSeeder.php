<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TipoSectorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tipos = [
            'Público',
            'Privado',
            'ONG Local',
            'Acádemia y de Investigación',
            'Sector Internacional',
            'Comunitario',
        ];

        foreach ($tipos as $tipo) {
            \App\Models\TipoSector::create([
                'nombre' => $tipo,
                'active_at' => now(),
            ]);
        }

        \App\Models\TipoSector::all()->each(function ($tipoSector) {
            $tipoSector->pais()->attach([1,2,3], ['active_at' => now()]);
        });
    }
}
