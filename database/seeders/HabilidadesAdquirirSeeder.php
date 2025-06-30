<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\HabilidadesAdquirir;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class HabilidadesAdquirirSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $habilidades = [
            'Habilidades sociales',
            'Habilidades de liderazgo',
            'Habilidades de gestión',
            'Habilidades de resolución de problemas',
            'Habilidades de adaptación',
            'Habilidades de innovación',
            'Habilidades de comunicación',
            'Habilidades de pensamiento crítico',
            'Habilidades de aprendizaje continuo',
            'Otras habilidades',
        ];

        foreach ($habilidades as $habilidad) {
            $registro = HabilidadesAdquirir::create([
                'nombre' => $habilidad,
                'active_at' => now(),
            ]);

            $registro->paises()->attach([1, 2, 3], ['active_at' => now()]);

        }
    }
}
