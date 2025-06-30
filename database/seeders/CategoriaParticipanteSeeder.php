<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoriaParticipanteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categorias = ["Perfil A", "Perfil B", "Alerta 1"];

        foreach ($categorias as $key => $categoria) {
            \App\Models\CategoriaParticipante::create([
                'nombre' => $categoria,
                'active_at' => now(),
                'tipo' => $key == 2 ? 'alerta' : 'perfil',
            ]);
        }
    }
}
