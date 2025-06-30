<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PropositoAlianzaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $propositos = [
            'Alineación/Planificación Estratégica',
            'Promoción/Fortalecimiento del entorno propicio',
            'Aprovechar la experiencia y la innovación del sector privado',
            'Movilizar recursos financieros del sector privado',
            'Proporcionar asistencia técnica al sector privado local',
            'Otro',
        ];

        foreach ($propositos as $proposito) {
            \App\Models\PropositoAlianza::create([
                'nombre' => $proposito,
                'active_at' => now(),
            ]);
        }

        \App\Models\PropositoAlianza::all()->each(function ($propositoAlianza) {
            $propositoAlianza->pais()->attach([1,2,3], ['active_at' => now()]);
        });
    }
}
