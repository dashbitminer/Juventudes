<?php

namespace Database\Seeders;

use App\Models\NoAceptaReferenciaRazon;
use App\Models\PcjFortaleceArea;
use App\Models\PcjSostenibilidad;
use App\Models\RecursoPrevisto;
use App\Models\RecursoPrevistoUsaid;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
class PcjFortaleceAreasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $values = [
            'Educación Básica',
            'Educación superior',
            'Salud física',
            'Salud mental',
            'Desarrollo de la Fuerza Laboral',
            'Medio ambiente',
            'Agricultura',
            'Espacio de lúdico y/o esparcimiento',
            'Seguridad y salvaguarda',
            'Gestión de riesgo a desastres'
        ];
                
                                    
        foreach ($values as $value) {
            $model = PcjFortaleceArea::create([
                'nombre' => $value,
                'active_at' => now(),
            ]);

            $model->paises()->attach([1, 2, 3]);
        }
    }
}
