<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DiscapacidadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $discapacidades = [
            'Física',
            'Auditiva',
            'Visual',
            'Cognitiva o Intelectual',
            'No poseo ningún tipo de discapacidad',
            'Prefiere no contestar',
        ];

        foreach ($discapacidades as $discapacidad) {
            \App\Models\Discapacidad::create([
                'nombre' => $discapacidad,
                'slug' => \Illuminate\Support\Str::slug($discapacidad),
                'active_at' => now(),
            ]);
        }
    }
}
