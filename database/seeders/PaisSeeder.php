<?php

namespace Database\Seeders;

use App\Models\Pais;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaisSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        Pais::create([
            'nombre' => 'Guatemala',
            'slug' => 'guatemala',
            'active_at' => now(),
        ]);

        Pais::create([
            'nombre' => 'El Salvador',
            'slug' => 'el-salvador',
            'active_at' => NULL,
        ]);

        Pais::create([
            'nombre' => 'Honduras',
            'slug' => 'honduras',
            'active_at' => NULL,
        ]);
    }
}
