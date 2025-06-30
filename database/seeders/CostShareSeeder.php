<?php

namespace Database\Seeders;

use App\Models\CostShareValoracion;
use Illuminate\Database\Seeder;

class CostShareSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        

        $this->call([
            CostShareCategoriaSeeder::class,
            CostShareValoracionSeeder::class,
            CostShareActividadSeeder::class,
            CostShareResultadoSeeder::class,
        ]);

       

    }
}
