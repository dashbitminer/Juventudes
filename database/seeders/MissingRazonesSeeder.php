<?php

namespace Database\Seeders;

use App\Models\Razon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MissingRazonesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $razones = [
            ['razon' => 'Problemas de conectividad y acceso a internet', 'categoria' => 32],
            ['razon' => 'Falta de acceso a dispositivos que permitan la telecomunicación', 'categoria' => 32],
            ['razon' => 'Desplazamiento forzado temporal', 'categoria' => 5],
        ];

        foreach ($razones as $razon) {
            Razon::create([
                'nombre' => $razon['razon'],
                'categoria_razon_id' => $razon['categoria'],
                'active_at' => now(),
            ]);
        }

    }
}
