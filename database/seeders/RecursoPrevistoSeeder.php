<?php

namespace Database\Seeders;

use App\Models\NoAceptaReferenciaRazon;
use App\Models\RecursoPrevisto;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
class RecursoPrevistoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $values = [
            'Fondos USAID',
            'Cost Share',
            'Leverage',
        ];
                                                          
        foreach ($values as $value) {
            $model = RecursoPrevisto::create([
                'nombre' => $value,
                'active_at' => now(),
            ]);

            $model->paises()->attach([1, 2, 3]);
        }
    }
}
