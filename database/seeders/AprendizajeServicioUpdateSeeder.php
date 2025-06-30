<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AprendizajeServicioUpdateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call([
            InclusionSocialTemaSeeder::class,
            MedioAmbienteTemaSeeder::class,
            CulturaTemaSeeder::class,
        ]);
    }
}
