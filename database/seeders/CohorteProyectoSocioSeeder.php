<?php

namespace Database\Seeders;

use App\Models\Modulo;
use Illuminate\Database\Seeder;
use App\Models\CohorteSubactividad;
use App\Models\CohorteProyectoSocio;
use App\Models\CohorteSubactividadModulo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CohorteProyectoSocioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cohorte = CohorteProyectoSocio::create([
            'cohorte_id' => 1,
            'pais_proyecto_socio_id' => 1,
            'active_at' => now(),
            'titulo_abierto' => false,
        ]);

        $subactividades = \App\Models\Subactividad::pluck('id')->random(3);
        $cohorte->subactividades()->attach($subactividades);


        CohorteSubactividad::get()->each(function ($cohorteSubactividad) {
            $cohorteSubactividad->modulos()->attach(Modulo::pluck('id')->random(3));
        });


        CohorteSubactividadModulo::get()->each(function ($cohorteSubactividadModulo) {
            $cohorteSubactividadModulo->submodulos()->attach(\App\Models\Submodulo::pluck('id')->random(3));
        });

    }
}
