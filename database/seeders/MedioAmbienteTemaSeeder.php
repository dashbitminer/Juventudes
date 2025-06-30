<?php

namespace Database\Seeders;

use App\Models\CostShareActividad;
use App\Models\CostShareCategoria;
use App\Models\CostShareValoracion;
use App\Models\CulturaTema;
use App\Models\InclusionSocialTema;
use App\Models\MedioAmbienteTema;
use Illuminate\Database\Seeder;
class MedioAmbienteTemaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $values = [
            'Agricultura Sostenible',
            'Energía limpia',
            'Cambio climático',
            'Desastres Naturales',
        ];
                                    
        foreach ($values as $value) {
            $model = MedioAmbienteTema::create([
                'nombre' => $value,
                'active_at' => now(),
            ]);

            $model->paises()->attach([1, 2, 3]);
        }
    }
}
