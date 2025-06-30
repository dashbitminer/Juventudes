<?php

namespace Database\Seeders;

use App\Models\NoAceptaReferenciaRazon;
use App\Models\PcjAlcance;
use App\Models\PcjSostenibilidad;
use App\Models\RecursoPrevisto;
use App\Models\RecursoPrevistoUsaid;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
class PcjAlcanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $values = [
            'Mejora y/o fortalecimiento de espacio comunitario',
            'Creación y/o construcción de espacio comunitario',
            'Habilitación de servicios en espacio comunitario',
            'Dotación de recursos en espacio comunitario',
            'Fortalecimiento de capacidades a población beneficiada',
            'Fortalecimiento de capacidades de la institución'
        ];
                                    
        foreach ($values as $value) {
            $model = PcjAlcance::create([
                'nombre' => $value,
                'active_at' => now(),
            ]);

            $model->paises()->attach([1, 2, 3]);
        }
    }
}
