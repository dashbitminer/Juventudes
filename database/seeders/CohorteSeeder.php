<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CohorteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        for ($i = 1; $i <= 10; $i++) {
            \App\Models\Cohorte::create([
                'nombre' => "Cohorte $i",
                'slug' => "cohorte-$i",
                // 'comparar_fecha_nacimiento' => today()->addMonth(),
                // 'fecha_inicio' => today()->subMonth(),
                // 'fecha_fin' => today()->addMonths(6),
                'active_at' => now(),
            ]);
        }

    }
}
