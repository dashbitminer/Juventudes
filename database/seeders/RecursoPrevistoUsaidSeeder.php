<?php

namespace Database\Seeders;

use App\Models\NoAceptaReferenciaRazon;
use App\Models\RecursoPrevisto;
use App\Models\RecursoPrevistoUsaid;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
class RecursoPrevistoUsaidSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $values = [
            'Basic Education',
            'Higher Education',
            'Workforce Development',
            'Agriculture',
            'Clean Energy',
            'Sustainable Landscapes'
        ];
                                    
        foreach ($values as $value) {
            $model = RecursoPrevistoUsaid::create([
                'nombre' => $value,
                'active_at' => now(),
            ]);

            $model->paises()->attach([1, 2, 3]);
        }
    }
}
