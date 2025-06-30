<?php

namespace Database\Seeders;


use App\Models\FactorEconomico;
use App\Models\FactorPersonalSocial;
use App\Models\FactorSalud;
use Illuminate\Database\Seeder;
class FactorPersonalSocialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $values = [
            'Poco apoyo familiar',
            'Cambios de residencia o migración',
            'Responsabilidades en el hogar',
            'Matrimonio o prioridad al trabajo',
            'Influencia de grupos sociales o pandillas',
            'Discriminación o estigmatización',
            'Transporte inseguro o insuficiente',
            'Falta de establecimientos educativos cercanos',
            'Maternidad o paternidad',
            'Otros (especificar)',
        ];
                                    
        foreach ($values as $value) {
            $model = FactorPersonalSocial::create([
                'nombre' => $value,
                'active_at' => now(),
            ]);

            $model->paises()->attach([1, 2, 3]);
        }
    }
}
