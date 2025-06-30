<?php

namespace Database\Seeders;

use App\Models\CostShareCategoria;
use App\Models\CostShareResultado;
use App\Models\CostShareValoracion;
use Illuminate\Database\Seeder;
class CostShareResultadoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $values = [
            'R1',
            'R2',
            'R3',
            'R4',
        ];
                                    
        foreach ($values as $value) {
            $model = CostShareResultado::create([
                'nombre' => $value,
                'active_at' => now(),
            ]);

            $model->paises()->attach([1, 2, 3]);
        }
    }
}
