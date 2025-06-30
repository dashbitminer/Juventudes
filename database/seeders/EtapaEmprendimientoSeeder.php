<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EtapaEmprendimientoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $values = [
            'Ideación',
            'Puesta en marcha',
            'Crecimiento',
        ];

        foreach ($values as $value) {
            \App\Models\EtapaEmprendimiento::create([
                'nombre' => $value,
                'active_at' => now(),
            ]);
        }

        \App\Models\EtapaEmprendimiento::all()->each(function ($model) {
            $model->pais()->attach([1, 2, 3], ['active_at' => now()]);
        });
    }
}
