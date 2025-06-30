<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaisProyectoSocioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (\App\Models\SocioImplementador::all() as $socio) {
            \App\Models\PaisProyectoSocio::create([
                'pais_proyecto_id' => 1,
                'socio_implementador_id' => $socio->id,
                'modalidad_id' => random_int(1, 3),
            ]);
        }
    }
}
