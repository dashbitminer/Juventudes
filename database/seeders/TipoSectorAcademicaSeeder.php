<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TipoSectorAcademicaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $academica = [
            'Universidad Pública',
            'Universidad Privada',
        ];

        foreach ($academica as $tipo) {
            \App\Models\TipoSectorAcademica::create([
                'nombre' => $tipo,
                'active_at' => now(),
            ]);
        }

        \App\Models\TipoSectorAcademica::all()->each(function ($tipoSectorAcademica) {
            $tipoSectorAcademica->pais()->attach([1,2,3], ['active_at' => now()]);
        });
    }
}
