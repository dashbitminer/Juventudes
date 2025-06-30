<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IngresosPromedioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $values = [
            'Por debajo del salario mínimo',
            'Salario mínimo',
            'Por encima del salario mínimo',
        ];

        foreach ($values as $value) {
            \App\Models\IngresosPromedio::create([
                'nombre' => $value,
                'active_at' => now(),
            ]);
        }

        \App\Models\IngresosPromedio::all()->each(function ($model) {
            $model->pais()->attach([1, 2, 3], ['active_at' => now()]);
        });
    }
}
