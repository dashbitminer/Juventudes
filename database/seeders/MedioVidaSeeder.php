<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MedioVidaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $values = [
            'Glasswing la facilitó',
            'Socio la facilitó',
            'Autogestionada por participante',
        ];

        foreach ($values as $value) {
            \App\Models\MedioVida::create([
                'nombre' => $value,
                'active_at' => now(),
            ]);
        }

        \App\Models\MedioVida::all()->each(function ($model) {
            $model->pais()->attach([1, 2, 3], ['active_at' => now()]);
        });
    }
}
