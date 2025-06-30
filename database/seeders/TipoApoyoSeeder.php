<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TipoApoyoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $values = [
            'Acompañamiento al proceso formativo',
            'Brindar oportunidades de crecimiento económico: laborales',
            'Brindar oportunidades: formativas- educativas',
            'Brindar oportunidades: de emprendimiento',
            'Brindar oportunidades: voluntariados',
            'Donaciones de recursos',
            'Organización de práctica de servicio',
            'Organización de practica laboral',
        ];

        foreach ($values as $value) {
            \App\Models\TipoApoyo::create([
                'nombre' => $value,
                'active_at' => now(),
            ]);
        }

        \App\Models\TipoApoyo::all()->each(function ($model) {
            $model->pais()->attach([1, 2, 3], ['active_at' => now()]);
        });
    }
}
