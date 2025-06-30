<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ResultadoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $resultados = ["Resultado 1", "Resultado 2", "Resultado 3", "Resultado 4"];

        foreach ($resultados as $key => $resultado) {
            \App\Models\Resultado::create([
                'nombre' => $resultado,
                'active_at' => now(),
            ]);
        }
    }
}
