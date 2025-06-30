<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaisProyectoSocioResultadoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (range(1, 4) as $index) {
            \App\Models\PaisProyectoSocioResultado::create([
                'pais_proyecto_socio_id' => 1,
                'resultado_id' => $index,
                'active_at' => now(),
            ]);
        }
    }
}
