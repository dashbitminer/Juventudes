<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ObjetivoAsistenciaAlianzaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $objetivos = [
            'Paz y seguridad',
            'Democracia y Gobernanza',
            'Salud',
            'Educación',
            'Crecimiento económico',
            'Cambio climático',
            'Ambiente',
            'Seguridad Alimentaria, nutrición',
            'Resiliencia',
            'Agua, higiene y saneamiento',
            'Otro',
        ];

        foreach ($objetivos as $objetivo) {
            \App\Models\ObjetivoAsistenciaAlianza::create([
                'nombre' => $objetivo,
                'active_at' => now(),
            ]);
        }

        \App\Models\ObjetivoAsistenciaAlianza::all()->each(function ($objetivoAsistenciaAlianza) {
            $objetivoAsistenciaAlianza->pais()->attach([1,2,3], ['active_at' => now()]);
        });

    }
}
