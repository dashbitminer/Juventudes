<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoriaRazonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categoria_razones = array(
            array(
                "Enlace realizado a través de un programa GW",
                2,
            ),
            array(
                "Autoenlace a una oportunidad externa a GW, anticipado al cierre del programa",
                2,
            ),
            array(
                "Incapacidad médica-física",
                2,
            ),
            array(
                "Motivos de salud mental",
                2,
            ),
            array(
                "Desplazamiento interno",
                2,
            ),
            array(
                "Condiciones de trabajo no remunerado y/o precario",
                2,
            ),
            array(
                "Carga académica",
                2,
            ),
            array(
                "Paternidad o maternidad",
                2,
            ),
            array(
                "Por caso judicial",
                2,
            ),
            array(
                "Razón desconocida",
                2,
            ),
            array(
                "Enlace realizado a través de un programa GW",
                1,
            ),
            array(
                "Autoenlace a una oportunidad externa a GW, anticipado al cierre del programa",
                1,
            ),
            array(
                "Incapacidad médica-física",
                1,
            ),
            array(
                "Motivos de salud mental",
                1,
            ),
            array(
                "Desplazamiento interno",
                1,
            ),
            array(
                "Migración irregular al extranjero",
                1,
            ),
            array(
                "Migración regular al extranjero",
                1,
            ),
            array(
                "Condiciones de ejecución, locación u horario",
                1,
            ),
            array(
                "Condiciones de trabajo no remunerado y/o precario",
                1,
            ),
            array(
                "Desmotivación",
                1,
            ),
            array(
                "Ausentismo escolar",
                1,
            ),
            array(
                "Carga académica",
                1,
            ),
            array(
                "Abandonó estudios",
                1,
            ),
            array(
                "Expulsión escolar",
                1,
            ),
            array(
                "Fallecimiento",
                1,
            ),
            array(
                "Paternidad o maternidad",
                1,
            ),
            array(
                "Incumplimiento de políticas del programa",
                1,
            ),
            array(
                "Por caso judicial",
                1,
            ),
            array(
                "Violencia",
                1,
            ),
            array(
                "Tutelar de NNA retiraron autorización para participación en el programa",
                1,
            ),
            array(
                "Razón desconocida",
                1,
            ),
            array(
                "Condiciones de ejecución, locación u horario",
                2,
            ),
            array(
                "Desastres naturales",
                1,
            ),
            array(
                "Desastres naturales",
                2,
            ),
            array(
                "Niñez y juventud en resguardo institucional",
                1,
            ),
            array(
                "Situaciones relacionadas a políticas de institución o de programa",
                1,
            ),
            array(
                "Desmotivación",
                2,
            ),
            array(
                "Expulsión escolar",
                2,
            ),
            array(
                "Razones de Reingreso",
                3,
            ),
        );

        foreach ($categoria_razones as $categoria_razon) {
            \App\Models\CategoriaRazon::create([
                'nombre'     => $categoria_razon[0],
                'tipo'       => $categoria_razon[1],
               // 'slug'       => \Illuminate\Support\Str::slug($categoria_razon[0]),
                'active_at'  => now(),
                'created_at' => now(),
                'created_by' => 1,
            ]);
        }

    }
}
