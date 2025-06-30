<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TipoAlianzaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tipos = [
            'Convenio',
            'Carta de entendimiento',
            'Carta de intención',
            'Intercambio de correos',
            'Otros'
        ];

        foreach ($tipos as $tipo) {
            \App\Models\TipoAlianza::create([
                'nombre' => $tipo,
                'active_at' => now(),
            ]);
        }

        \App\Models\TipoAlianza::all()->each(function ($tipoAlianza) {
            $tipoAlianza->pais()->attach([1,2,3], ['active_at' => now()]);
        });
    }
}
