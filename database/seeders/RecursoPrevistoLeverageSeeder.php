<?php

namespace Database\Seeders;


use App\Models\RecursoPrevistoCostShare;
use App\Models\RecursoPrevistoLeverage;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
class RecursoPrevistoLeverageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $values = [
            'HGBF',
            'Audacious',
            'Otro'
        ];
                                    
        foreach ($values as $value) {
            $model = RecursoPrevistoLeverage::create([
                'nombre' => $value,
                'active_at' => now(),
            ]);

            $model->paises()->attach([1, 2, 3]);
        }
    }
}
