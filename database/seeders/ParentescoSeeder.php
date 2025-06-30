<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ParentescoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $parentesco = [
            'Mamá',
            'Papá',
            'Hermana/o',
            'Abuela/o',
            'Cónyugue',
            'Otro',
        ];

        foreach ($parentesco as $parentesco) {
            \App\Models\Parentesco::create([
                'nombre' => $parentesco,
                'slug' => \Illuminate\Support\Str::slug($parentesco),
                'active_at' => now(),
            ]);
        }
    }
}
