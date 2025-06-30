<?php

namespace Database\Seeders;

use App\Models\CostShareActividad;
use App\Models\CostShareCategoria;
use App\Models\CostShareValoracion;
use App\Models\CulturaTema;
use App\Models\InclusionSocialTema;
use Illuminate\Database\Seeder;
class CulturaTemaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $values = [
            'Preservación cultural e histórica',
            'Educación cívico y compromiso cívico',
            'Comunidad e identidad territorial',
        ];
                                    
        foreach ($values as $value) {
            $model = CulturaTema::create([
                'nombre' => $value,
                'active_at' => now(),
            ]);

            $model->paises()->attach([1, 2, 3]);
        }
    }
}
