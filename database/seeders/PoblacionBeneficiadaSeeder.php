<?php

namespace Database\Seeders;

use App\Models\NoAceptaReferenciaRazon;
use App\Models\PcjAlcance;
use App\Models\PcjSostenibilidad;
use App\Models\PoblacionBeneficiada;
use App\Models\RecursoPrevisto;
use App\Models\RecursoPrevistoUsaid;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
class PoblacionBeneficiadaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $values = [
            'Niñez',
            'Adolescencia',
            'Mujeres',
            'Población en general',
            'Personas adultas mayores',
            'Personas con condición de discapacidad',
            'Población LGTBIQ+',
            'Pueblos y comunidades indígenas',
            'Migrantes',
            'Familias'
        ];
                                    
        foreach ($values as $value) {
            $model = PoblacionBeneficiada::create([
                'nombre' => $value,
                'active_at' => now(),
            ]);

            $model->paises()->attach([1, 2, 3]);
        }
    }
}
