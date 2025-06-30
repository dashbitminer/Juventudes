<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TamanoEmpresaPrivadaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tamanos = [
            [
                'name' => 'Grande',
                'comment' => '(más de 100 empleados)'
            ],
            [
                'name' => 'Mediano',
                'comment' => '(50-100 empleados)'
            ],
            [
                'name' => 'Pequeño',
                'comment' => '(10-50 empleados)'
            ],
            [
                'name' => 'Micro',
                'comment' => '(<10 empleados)'
            ],
        ];

        foreach ($tamanos as $tamano) {
            \App\Models\TamanoEmpresaPrivada::create([
                'nombre' => $tamano['name'],
                'comentario' => $tamano['comment'],
                'active_at' => now(),
            ]);
        }

        \App\Models\TamanoEmpresaPrivada::all()->each(function ($tamanoEmpresaPrivada) {
            $tamanoEmpresaPrivada->pais()->attach([1,2,3], ['active_at' => now()]);
        });

    }
}
