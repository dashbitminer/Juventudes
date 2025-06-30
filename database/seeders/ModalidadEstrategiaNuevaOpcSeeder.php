<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ModalidadEstrategiaNuevaOpcSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $modalidadEstrategiaNombre = 'Acceso a oportunidades/medios de vida (Empleo, Emprendimiento o Formación)';
        $modalidadEstrategiaAlianza = \App\Models\ModalidadEstrategiaAlianza::where('nombre', $modalidadEstrategiaNombre)->first();
        
        if(!$modalidadEstrategiaAlianza) {
            $modalidadEstrategia = \App\Models\ModalidadEstrategiaAlianza::create([
                'nombre' => $modalidadEstrategiaNombre,
                'active_at' => now(),
                'comentario' => 'Comentario de ' . $modalidadEstrategiaNombre,
            ]);

            $modalidadEstrategia->pais()->attach([1,2,3], ['active_at' => now()]);
        }
    }
}
