<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ServiciosDesarrollar;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ServiciosDesarrollarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $opciones = [
            'Servicios de asistencia alimentaria',
            'Servicios de salud',
            'Servicios educativos',
            'Servicios ambientales',
            'Servicios de protección civil',
            'Servicios culturales',
            'Servicios deportivos',
            'Servicios de apoyo a la comunidad',
            'Servicios de voluntariado',
            'Servicios administrativos',
            'Servicios comerciales',
            'Servicios de apoyo tecnológico',
            'Otros servicios',
        ];

        foreach ($opciones as $opcion) {
            $registro = ServiciosDesarrollar::create([
                'nombre' => $opcion,
                'active_at' => now(),
            ]);

            $registro->paises()->attach([1, 2, 3], ['active_at' => now()]);

        }
    }
}
