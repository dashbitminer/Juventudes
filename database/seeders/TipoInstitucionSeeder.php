<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TipoInstitucionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $values = [
            'Organizaciones empresariales',
            'Organización No Gubernamental (ONG)',
            'Organizaciones gubernamentales',
            'Organizaciones internacionales',
            'Organizaciones religiosas',
            'Organizaciones educativas',
            'Otra',
        ];

        foreach ($values as $value) {
            \App\Models\TipoInstitucion::create([
                'nombre' => $value,
                'active_at' => now(),
            ]);
        }

        \App\Models\TipoInstitucion::all()->each(function ($model) {
            $model->pais()->attach([1, 2, 3], ['active_at' => now()]);
        });
    }
}
