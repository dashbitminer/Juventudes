<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PersonaViveParejaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['nombre' => 'Pareja'],
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
