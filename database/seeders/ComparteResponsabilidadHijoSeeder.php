<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ComparteResponsabilidadHijoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $comparte_responsabilidad_hijo = [
            'Pareja',
            'Solo/a',
            'Mis padres',
            'Mis abuelos',
            'Otros familiares',
        ];

        foreach ($comparte_responsabilidad_hijo as $comparte_responsabilidad_hijo) {
            \App\Models\ComparteResponsabilidadHijo::create([
                'nombre' => $comparte_responsabilidad_hijo,
                'slug' => \Illuminate\Support\Str::slug($comparte_responsabilidad_hijo),
                'active_at' => now(),
            ]);
        }
    }
}
