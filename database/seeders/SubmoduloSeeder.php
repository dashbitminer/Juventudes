<?php

namespace Database\Seeders;

use App\Models\Submodulo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubmoduloSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Submodulo::factory(20)->create();
    }
}
