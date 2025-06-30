<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EstadoCivilSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $estadosCiviles = [
            'Soltera/o',
            'Casada/o',
            'Divorciada/o',
            'Unión Libre',
            'Viuda/o',
        ];

        foreach ($estadosCiviles as $estadoCivil) {
            \App\Models\EstadoCivil::create([
                'nombre' => $estadoCivil,
                'slug' => \Illuminate\Support\Str::slug($estadoCivil),
                'active_at' => now(),
            ]);
        }
    }
}
