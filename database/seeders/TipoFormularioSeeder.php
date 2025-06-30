<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TipoFormularioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tipos = [
            [
                'nombre' => 'Formulario de registro de participantes',
                'resultado_id' => 1,
            ],
            [
                'nombre' => 'Formulario socioeconómico',
                'resultado_id' => 1,
            ],
            [
                'nombre' => 'Formulario prealianzas',
                'resultado_id' => 3,
            ],
            [
                'nombre' => 'Formulario seguimiento prealianzas',
                'resultado_id' => 3,
            ],
            [
                'nombre' => 'Formulario alianzas',
                'resultado_id' => 3,
            ],
            [
                'nombre' => 'Formulario seguimiento de alianzas',
                'resultado_id' => 3,
            ],
            [
                'nombre' => 'Formulario de apalancamiento',
                'resultado_id' => 3,
            ],
            [
                'nombre' => 'Formulario de ficha de aprendizaje de servicio',
                'resultado_id' => 4,
            ],
            [
                'nombre' => 'Formulario de ficha de emprendimiento',
                'resultado_id' => 4,
            ],
            [
                'nombre' => 'Formulario de ficha de formación',
                'resultado_id' => 4,
            ],
            [
                'nombre' => 'Formulario de ficha de proyecto de servicio comunitario',
                'resultado_id' => 4,
            ],
            [
                'nombre' => 'Formulario de ficha de voluntariado',
                'resultado_id' => 4,
            ],
            [
                'nombre' => 'Formulario de ficha practica para empleabilidad',
                'resultado_id' => 4,
            ],
            [
                'nombre' => 'Formulario de ficha de empleo',
                'resultado_id' => 4,
            ],
            [
                'nombre' => 'Formulario de directorio',
                'resultado_id' => 4,
            ],
        ];

        foreach ($tipos as $tipo) {
            \App\Models\TipoFormulario::create($tipo);
        }
    }
}
