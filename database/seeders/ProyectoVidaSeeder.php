<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProyectoVidaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $proyectoVida = [
            ['nombre' => 'Conseguir un empleo formal', 'comentario' => null],
            ['nombre' => 'Emprender un negocio propio', 'comentario' => null],
            ['nombre' => 'Continuar con tu formación académica o profesional', 'comentario' => '(estudios secundarios, universitarios, cursos técnicos, etc.)'],
            ['nombre' => 'Otra', 'comentario' => '(por favor, especifica)'],
        ];

        foreach ($proyectoVida as $proyectoVida) {
            \App\Models\ProyectoVida::create([
                'nombre' => $proyectoVida['nombre'],
                'slug' => \Illuminate\Support\Str::slug($proyectoVida['nombre']),
                'comentario' => $proyectoVida['comentario'],
                'active_at' => now(),
            ]);
        }
    }
}
