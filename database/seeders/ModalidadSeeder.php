<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ModalidadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $modalidad = [
            "Prototipo",
            "MAO-TaRL",
            "MAO-INTECAP"
        ];

        foreach ($modalidad as $modalidad) {
            \App\Models\Modalidad::create([
                'nombre' => $modalidad,
                'slug' => \Illuminate\Support\Str::slug($modalidad),
                'active_at' => now(),
            ]);
        }
    }
}
