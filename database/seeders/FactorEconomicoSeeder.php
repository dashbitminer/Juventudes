<?php

namespace Database\Seeders;


use App\Models\FactorEconomico;
use Illuminate\Database\Seeder;
class FactorEconomicoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $values = [
            'Falta de dinero para cubrir gastos escolares',
            'Necesidad de trabajar',
            'Horarios incompatibles entre estudio y otras responsabilidades',
        ];
                                    
        foreach ($values as $value) {
            $model = FactorEconomico::create([
                'nombre' => $value,
                'active_at' => now(),
            ]);

            $model->paises()->attach([1, 2, 3]);
        }
    }
}
