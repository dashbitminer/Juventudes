<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrigenEmpresaPrivadaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $origenes = [
            'Basada en el país anfitrion',
            'Con base en EE.UU',
            'Basado en terceros países'
        ];

        foreach ($origenes as $origen) {
            \App\Models\OrigenEmpresaPrivada::create([
                'nombre' => $origen,
                'active_at' => now(),
            ]);
        }

        \App\Models\OrigenEmpresaPrivada::all()->each(function ($origenEmpresaPrivada) {
            $origenEmpresaPrivada->pais()->attach([1,2,3], ['active_at' => now()]);
        });
    }
}
