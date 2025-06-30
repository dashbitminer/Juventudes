<?php

namespace Database\Seeders;

use App\Models\Submodulo;
use App\Models\Titulo;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TituloSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Titulo::factory(20)->create();
    }
}
