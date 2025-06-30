<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MedioVerificacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $values = [
            'Oferta de trabajo',
            'Boleta de pago',
            'Carnet de la empresa',
            'Constancia de salario',
            'Contrato',
            'Otros',
        ];

        foreach ($values as $value) {
            \App\Models\MedioVerificacion::create([
                'nombre' => $value,
                'active_at' => now(),
            ]);
        }

        \App\Models\MedioVerificacion::all()->each(function ($model) {
            $model->pais()->attach([1, 2, 3], ['active_at' => now()]);
        });
    }
}
