<?php

namespace Database\Seeders;

use App\Models\CostShareValoracion;
use Illuminate\Database\Seeder;

class FactoresSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        

        $this->call([
            FactorEconomicoSeeder::class,
            FactorSaludSeeder::class,
            FactorPersonalSocialSeeder::class,
        ]);

       

    }
}
