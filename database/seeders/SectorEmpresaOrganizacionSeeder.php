<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SectorEmpresaOrganizacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $values = [
            'Agricultura, ganadería y pesca',
            'Industria manufacturera',
            'Energía y recursos naturales',
            'Construcción e inmobiliaria',
            'Comercio y distribución',
            'Servicios financieros',
            'Tecnología e informática',
            'Transporte y logística',
            'Turismo y hostelería',
            'Salud y bienestar',
            'Educación y formación',
            'Medios de comunicación y entretenimiento',
            'Servicios profesionales y consultoría',
            'Servicios públicos y administración',
            'Arte y cultura',
            'ONGs y organizaciones sin multas de lucro',
        ];

        foreach ($values as $value) {
            \App\Models\SectorEmpresaOrganizacion::create([
                'nombre' => $value,
                'active_at' => now(),
            ]);
        }

        \App\Models\SectorEmpresaOrganizacion::all()->each(function ($model) {
            $model->pais()->attach([1, 2, 3], ['active_at' => now()]);
        });
    }
}
