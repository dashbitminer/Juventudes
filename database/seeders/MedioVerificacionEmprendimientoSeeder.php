<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MedioVerificacionEmprendimientoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $values = [
            'Modelo de negocio',
            'Libro de caja',
            'Otros',
        ];

        foreach ($values as $value) {
            \App\Models\MedioVerificacionEmprendimiento::create([
                'nombre' => $value,
                'active_at' => now(),
            ]);
        }

        \App\Models\MedioVerificacionEmprendimiento::all()->each(function ($model) {
            $model->pais()->attach([1, 2, 3], ['active_at' => now()]);
        });
    }
}
