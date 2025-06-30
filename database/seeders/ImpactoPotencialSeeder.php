<?php

namespace Database\Seeders;

use App\Models\CostShareCategoria;
use App\Models\ImpactoPotencial;
use Illuminate\Database\Seeder;
class ImpactoPotencialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $values = [
            'Jóvenes directos beneficiados',
            'Contrapartida',
            'Formación de alianzas', 
            'Inserción a medios de vida'
        ];
                                    
        foreach ($values as $value) {
            $model = ImpactoPotencial::create([
                'nombre' => $value,
                'active_at' => now(),
            ]);

            $model->paises()->attach([1, 2, 3]);
        }
    }
}
