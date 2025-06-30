<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RubroEmprendimientoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $values = [
            'Agricultura, ganadería y pesca',
            'Alimentación y Bebidas',
            'Arte y Entretenimiento',
            'Comercio Electrónico',
            'Comercio y distribución',
            'Construcción e inmobiliaria',
            'Educación y formación',
            'Energía y recursos naturales',
            'Industria manufacturera',
            'Medios de comunicación y entretenimiento',
            'Moda y Accesorios',
            'Salud y bienestar',
            'Servicios financieros',
            'Servicios Profesionales',
            'Tecnología e informática',
            'Transporte y logística',
            'Turismo y hostelería',
        ];

        foreach ($values as $value) {
            \App\Models\RubroEmprendimiento::create([
                'nombre' => $value,
                'active_at' => now(),
            ]);
        }

        \App\Models\RubroEmprendimiento::all()->each(function ($model) {
            $model->pais()->attach([1, 2, 3], ['active_at' => now()]);
        });
    }
}
