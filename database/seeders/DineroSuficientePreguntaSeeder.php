<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DineroSuficientePreguntaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $preguntas = [
            'Comida/alimentación.',
            'Servicio de energía eléctrica.',
            'Servicio de agua potable.',
            'Chimbo o Cilindro de gas/leña para cocinar.',
            'Gastos en educación.',
            'Gastos de salud física.',
            'Gastos de salud mental',
            'Vestimenta, ropa/zapatos etc.',
            'Recreación.',
            'Viajes.',
            'Ahorro.',
        ];

        foreach ($preguntas as $pregunta) {
            \App\Models\DineroSuficientePregunta::create([
                'nombre' => $pregunta,
                'slug' => \Illuminate\Support\Str::slug($pregunta),
                'active_at' => now(),
            ]);
        }
    }
}
