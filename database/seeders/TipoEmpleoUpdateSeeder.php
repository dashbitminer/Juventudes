<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TipoEmpleoUpdateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $values = [
            'Beca mi primer empleo',
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
