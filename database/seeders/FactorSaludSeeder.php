<?php

namespace Database\Seeders;


use App\Models\FactorEconomico;
use App\Models\FactorSalud;
use Illuminate\Database\Seeder;
class FactorSaludSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $values = [
            'Problemas de salud',
            'Embarazo de riesgo',
            'Dificultad para acceder a apoyo psicológico o médico',

        ];
                                    
        foreach ($values as $value) {
            $model = FactorSalud::create([
                'nombre' => $value,
                'active_at' => now(),
            ]);

            $model->paises()->attach([1, 2, 3]);
        }
    }
}
