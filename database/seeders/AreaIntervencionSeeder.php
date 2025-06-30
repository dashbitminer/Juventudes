<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AreaIntervencionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $values = [
            'Educación',
            'Salud',
            'Bienestar social',
            'Derechos humanos',
            'Medio ambiente',
            'Cultura',
            'Desarrollo económico',
            'Investigación y desarrollo',
            'Servicio civil',
            'Otra',
        ];

        foreach ($values as $value) {
            \App\Models\AreaIntervencion::create([
                'nombre' => $value,
                'active_at' => now(),
            ]);
        }

        \App\Models\AreaIntervencion::all()->each(function ($model) {
            $model->pais()->attach([1, 2, 3], ['active_at' => now()]);
        });
    }
}
