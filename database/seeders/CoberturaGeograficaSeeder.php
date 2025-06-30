<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CoberturaGeograficaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $opciones = [
            'Nacional', 'Internacional', 'Nacional e Internacional', 'No definido'
        ];

        foreach ($opciones as $opcion) {
            $cobertura = \App\Models\CoberturaGeografica::create([
                'nombre' => $opcion,
                'slug' => \Illuminate\Support\Str::slug($opcion),
                'active_at' => now(),
            ]);

            $cobertura->pais()->attach([1,2,3], ['active_at' => now()]);
            // $cobertura->pais()->attach(2, ['active_at' => now()]);
            // $cobertura->pais()->attach(3, ['active_at' => now()]);
        }
    }
}
