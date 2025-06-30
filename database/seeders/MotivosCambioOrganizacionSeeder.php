<?php

namespace Database\Seeders;

use App\Models\MotivosCambioOrganizacion;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MotivosCambioOrganizacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $opciones = [
            'Incompatibilidad de horarios',
            'Falta de atractivo en las actividades',
            'Trato inadecuado del personal',
            'Otro',
        ];

        foreach ($opciones as $opcion) {
            $registro = MotivosCambioOrganizacion::create([
                'nombre' => $opcion,
                'active_at' => now(),
            ]);

            $registro->paises()->attach([1, 2, 3], ['active_at' => now()]);

        }
    }
}
