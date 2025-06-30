<?php

namespace Database\Seeders;


use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PersonaViveSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['nombre' => 'Madre'],
            ['nombre' => 'Padre'],
            ['nombre' => 'Madrastra'],
            ['nombre' => 'Padrastro'],
            ['nombre' => 'Hemanas/os'],
            ['nombre' => 'Hijas/os'],
            ['nombre' => 'Abuela'],
            ['nombre' => 'Abuelo'],
            ['nombre' => 'Tíos'],
            ['nombre' => 'Otros (especificar)'],
        ];

        foreach ($data as $row) {
            \App\Models\PersonaVive::create([
                'nombre' => $row['nombre'],
                'slug' => Str::slug($row['nombre']),
                'active_at' => now(),
            ]);
        }
    }
}
