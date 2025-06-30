<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ModalidadEstrategiaAlianzaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $modalidades = [
            'Apoyar el desarrollo de negocios individuales y modelos de negocio',
            'Asociaciones de valor compartido',
            'Intercambio de conocimientos e información',
            'Mesa de trabajo/diálogo político',
            'Acuerdos de riesgo compartido/Financiación combinada',
            'Financiamiento basado en resultados',
            'Facilitación de inversiones',
            'Interactuar con redes y plataformas empresariales para el desarrollo del ecosistema'
        ];

        foreach ($modalidades as $modalidad) {
            \App\Models\ModalidadEstrategiaAlianza::create([
                'nombre' => $modalidad,
                'active_at' => now(),
                'comentario' => 'Comentario de ' . $modalidad,
            ]);
        }

        \App\Models\ModalidadEstrategiaAlianza::all()->each(function ($modalidadEstrategia) {
            $modalidadEstrategia->pais()->attach([1,2,3], ['active_at' => now()]);
        });


    }
}
