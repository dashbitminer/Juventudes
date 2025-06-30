<?php

namespace Database\Seeders;

use App\Models\CostShareActividad;
use App\Models\CostShareCategoria;
use App\Models\CostShareValoracion;
use Illuminate\Database\Seeder;
class CostShareActividadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $values = [
            'Capacitaciones',
            'Financiamiento/Cofinanciamiento',
            'Desarrollo de estándares',
            'Creación de modelos',
            'Diseño de programas',
            'Promoción',
            'Prestación directa de servicios',
            'Investigación',
            'Soporte técnico/Asesorias',
            'Remosamiento',
            'Voluntariado',
            'Empleabilidad',
            'Emprendimiento',
            'Evento',
            'Formaciones complementarias',
            'Proyectos comunitarios juveniles'
        ];
                                    
        foreach ($values as $value) {
            $model = CostShareActividad::create([
                'nombre' => $value,
                'active_at' => now(),
            ]);

            $model->paises()->attach([1, 2, 3]);
        }
    }
}
