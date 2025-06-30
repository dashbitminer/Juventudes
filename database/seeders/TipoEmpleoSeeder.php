<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TipoEmpleoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $values = [
            'Temporal',
            'Medio tiempo',
            'Por horas',
            'Pasantía',
            'Informal',
            'Formal',
            'Tiempo completo',
        ];

        foreach ($values as $value) {
            \App\Models\TipoEmpleo::create([
                'nombre' => $value,
                'active_at' => now(),
            ]);
        }

        \App\Models\TipoEmpleo::all()->each(function ($model) {
            $model->pais()->attach([1, 2, 3], ['active_at' => now()]);
        });
    }
}
