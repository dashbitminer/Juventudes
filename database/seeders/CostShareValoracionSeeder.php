<?php

namespace Database\Seeders;

use App\Models\CostShareCategoria;
use App\Models\CostShareValoracion;
use Illuminate\Database\Seeder;
class CostShareValoracionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $values = [
            'Valor de mercado',
            'Valor de alquiler',
            'Valor de avaluo',
        ];
                                    
        foreach ($values as $value) {
            $model = CostShareValoracion::create([
                'nombre' => $value,
                'active_at' => now(),
            ]);

            $model->paises()->attach([1, 2, 3]);
        }
    }
}
