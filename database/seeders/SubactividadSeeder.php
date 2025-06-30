<?php

namespace Database\Seeders;

use App\Models\Subactividad;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubactividadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Subactividad::factory(20)->create();
    }
}
