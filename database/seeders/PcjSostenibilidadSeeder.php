<?php

namespace Database\Seeders;

use App\Models\NoAceptaReferenciaRazon;
use App\Models\PcjSostenibilidad;
use App\Models\RecursoPrevisto;
use App\Models\RecursoPrevistoUsaid;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
class PcjSostenibilidadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $values = [
            'Se vincula a comités juveniles',
            'Se vincula a Organizaciones lideradas por jóvenes',
            'Desarrollar voluntariado o alternativas para dar seguimiento a PCJ',
            'Generar voluntariado o alternativas para dar seguimiento a PCJ'
        ];
                                    
        foreach ($values as $value) {
            $model = PcjSostenibilidad::create([
                'nombre' => $value,
                'active_at' => now(),
            ]);

            $model->paises()->attach([1, 2, 3]);
        }
    }
}
