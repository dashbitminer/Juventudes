<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TipoSectorComunitariaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tiposGT = [
            'COCODES',
            'Alcaldía Indigenas',
            'Asociaciones',
            'Persona particular',
        ];

        foreach ($tiposGT as $tipoGT) {
            \App\Models\TipoSectorComunitaria::create([
                'nombre' => $tipoGT,
                'active_at' => now(),
            ]);
        }

        \App\Models\TipoSectorComunitaria::all()->each(function ($tipoSectorComunitaria) {
            if ($tipoSectorComunitaria->id == 3) {
                $tipoSectorComunitaria->pais()->attach([1,2], ['active_at' => now()]);
            }else{
                $tipoSectorComunitaria->pais()->attach(1, ['active_at' => now()]);
            }
        });

        $tiposSv = [
            'Asociación de Desarrollo Comunal (ADESCO)',
        ];

        foreach ($tiposSv as $tipoSv) {
            \App\Models\TipoSectorComunitaria::create([
                'nombre' => $tipoSv,
                'active_at' => now(),
            ]);
        }

        \App\Models\TipoSectorComunitaria::all()->each(function ($tipoSectorComunitaria) {
            $tipoSectorComunitaria->pais()->attach(2, ['active_at' => now()]);
        });




    }
}
