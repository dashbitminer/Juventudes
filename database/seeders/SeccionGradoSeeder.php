<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SeccionGradoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $seecion_grado = [
            'A o 1',
            'B o 2',
            'C o 3',
            'D o 4',
            'E o 5',
            'F o 6',
            'G o 7',
            'Sección única',
        ];

        foreach ($seecion_grado as $seccion) {
            \App\Models\SeccionGrado::create([
                'nombre' => $seccion,
                'slug' => \Illuminate\Support\Str::slug($seccion),
                'active_at' => now(),
            ]);
        }
    }
}
