<?php

namespace Database\Seeders;

use App\Models\CostShareCategoria;

use Illuminate\Database\Seeder;
class CostShareCategoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $values = [
            'Costo de 1 RRHH',
            'Infraestructura (alquiler)',
            'Equipos (Alquiler)',
            'Logística (Incluidos costos de viaje, alojamiento, alimentación)',
            'Material Impreso',
            'Productos médicos',
            'Tiempo de aire',
            'Vehículos furgonetas',
            'Diagnósticos',
            'Contribución',
            'Prestación de servicios',
        ];
                                    
        foreach ($values as $value) {
            $model = CostShareCategoria::create([
                'nombre' => $value,
                'active_at' => now(),
            ]);

            $model->paises()->attach([1, 2, 3]);
        }
    }
}
