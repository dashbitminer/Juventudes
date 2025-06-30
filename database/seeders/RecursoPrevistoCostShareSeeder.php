<?php

namespace Database\Seeders;


use App\Models\RecursoPrevistoCostShare;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
class RecursoPrevistoCostShareSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $values = [
            'Glasswing',
            'Gobierno',
            'Multilateral',
            'Otro'
        ];
                                    
        foreach ($values as $value) {
            $model = RecursoPrevistoCostShare::create([
                'nombre' => $value,
                'active_at' => now(),
            ]);

            $model->paises()->attach([1, 2, 3]);
        }
    }
}
