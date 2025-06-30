<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CapitalSemillaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $values = [
            'Glasswing',
            'Socio',
            'Instituciones Publicas',
            'Instituciones Privadas',
            'Otros',
        ];

        foreach ($values as $value) {
            \App\Models\CapitalSemilla::create([
                'nombre' => $value,
                'active_at' => now(),
            ]);
        }

        \App\Models\CapitalSemilla::all()->each(function ($model) {
            $model->pais()->attach([1, 2, 3], ['active_at' => now()]);
        });
    }
}
