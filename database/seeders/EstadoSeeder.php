<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EstadoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $estados = [
            ['nombre' => "Activo", 'icon' => "icon.check", 'color' => "green"],
            ['nombre' => "Inactivo", 'icon' => "icon.clock", 'color' => "gray"],
            ['nombre' => "Pausa", 'icon' => "icon.x-mark", 'color' => "orange"],
            ['nombre' => "Reingreso", 'icon' => "icon.arrow-uturn-left", 'color' => "purple"],
            ['nombre' => "Desertado", 'icon' => "icon.trash", 'color' => "red"],
            ['nombre' => "Graduado", 'icon' => "icon.academic-cap", 'color' => "sky"],
        ];


        foreach ($estados as $estado) {
            \App\Models\Estado::create([
                'nombre' => $estado["nombre"],
                'icon' => $estado["icon"],
                'color' => $estado["color"],
                'comentario' => null,
                'active_at' => now(),
            ]);
        }
    }
}
