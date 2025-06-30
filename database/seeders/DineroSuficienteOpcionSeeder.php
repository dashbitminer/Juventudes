<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DineroSuficienteOpcionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $opciones = [
            'No hemos tenido para eso',
            'Pocas veces hemos tenido para eso',
            'A veces hemos tenido para eso',
            'Casi siempre hemos tenido para eso',
            'Siempre hemos tenido para eso',
        ];

        foreach ($opciones as $opcion) {
            \App\Models\DineroSuficienteOpcion::create([
                'nombre' => $opcion,
                'slug' => \Illuminate\Support\Str::slug($opcion),
                'active_at' => now(),
            ]);
        }
    }
}
