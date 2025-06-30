<?php

namespace Database\Seeders;


use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SocioImplementadorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $socio = [
            ["nombre" => "Glasswing", "pais_id" => 2],
            ["nombre" => "Fusalmo", "pais_id" => 1],
            ["nombre" => "World Vision", "pais_id" => 1],
        ];

        foreach ($socio as $s) {
            \App\Models\SocioImplementador::create([
                'nombre'    => $s['nombre'],
                'slug'      => Str::slug($s['nombre']),
                'pais_id'   => $s['pais_id'],
                'active_at' => now(),
            ]);
        }
    }
}
