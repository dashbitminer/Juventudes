<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NivelEducativoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $nivelEducacion = [
        //     'No tuvo la oportunidad de estudiar',
        //     'Educación Inicial',
        //     'Primaria (de 1 a 6 grado)',
        //     'Secundaria (7 a 9 grado)',
        //     'Bachillerato',
        //     'Estudios técnicos',
        //     'Estudios universitarios',
        //     'Estudios de máster y PhD',
        // ];

        // foreach ($nivelEducacion as $nivel) {
        //     \App\Models\NivelEducativo::create([
        //         'nombre' => $nivel,
        //         'slug' => \Illuminate\Support\Str::slug($nivel),
        //         'active_at' => now(),
        //     ]);
        // }

        $nivelEducacion = [
            ['nivel' => 'No tuvo la oportunidad de estudiar', 'categoria' => 'No tuvo oportunidad de estudiar'],
            ['nivel' => 'Educación Inicial', 'categoria' => 'educación inicial'],
            ['nivel' => '1° Grado', 'categoria' => 'primaria'],
            ['nivel' => '2° Grado', 'categoria' => 'primaria'],
            ['nivel' => '3° Grado', 'categoria' => 'primaria'],
            ['nivel' => '4° Grado', 'categoria' => 'primaria'],
            ['nivel' => '5° Grado', 'categoria' => 'primaria'],
            ['nivel' => '6° Grado', 'categoria' => 'primaria'],
            ['nivel' => '7° Grado', 'categoria' => 'basica'],
            ['nivel' => '8° Grado', 'categoria' => 'basica'],
            ['nivel' => '9° Grado', 'categoria' => 'basica'],
            ['nivel' => '1 Bachillerato/Diversificado (10 Grado) ', 'categoria' => 'bachillerato'],
            ['nivel' => '2 Bachillerato/Diversificado (11 Grado)', 'categoria' => 'bachillerato'],
            ['nivel' => '3 Bachillerato/Diversificado (12 Grado) ', 'categoria' => 'bachillerato'],
            ['nivel' => '1 Bachillerato Técnico', 'categoria' => 'bachillerato'],
            ['nivel' => '2 Bachillerato Técnico', 'categoria' => 'bachillerato'],
            ['nivel' => '3 Bachillerato Técnico', 'categoria' => 'bachillerato'],
          //  ['nivel' => '3 Bachillerato Técnico', 'categoria' => 'bachillerato'],
            ['nivel' => 'Universidad', 'categoria' => 'estudios superiores'],
        ];

        foreach ($nivelEducacion as $nivel) {
            \App\Models\NivelEducativo::create([
                'nombre' => $nivel['nivel'],
                'categoria' => $nivel['categoria'],
                'slug' => \Illuminate\Support\Str::slug($nivel['nivel']),
                'active_at' => now(),
            ]);
        }
    }
}
