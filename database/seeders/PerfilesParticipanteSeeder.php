<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PerfilesParticipanteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $perfiles = [
            "Perfil A",
            "Perfil B",
        ];

        foreach ($perfiles as $perfil) {
            \App\Models\PerfilesParticipante::create([
                'nombre' => $perfil,
                'active_at' => now(),
                'slug' => \Illuminate\Support\Str::slug($perfil),
            ]);
        }
    }
}
