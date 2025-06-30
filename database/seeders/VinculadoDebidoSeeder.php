<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VinculadoDebidoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $opciones = [
            'Proyecto de Servicio Comunitario',
            'Aprendizaje de servicio',
            'Otras',
        ];

        foreach ($opciones as $opcion) {
            $record = \App\Models\VinculadoDebido::create([
                'nombre' => $opcion,
                'active_at' => now(),
            ]);

            $record->pais()->attach([1, 2, 3], ['active_at' => now()]);
        }
    }
}
