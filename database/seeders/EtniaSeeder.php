<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EtniaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $etnia = [
            'Cacaopera',
            'Garífuna',
            'Lenca',
            'Maya',
            'Mestizo/ladino',
            'Pipil',
            'Xinka',
            'Ninguno',
            'No sabe',
            'Prefiere no contestar',
        ];

        $gt = [2, 3,5,7];
        $comun = [8,9,10];

        foreach ($etnia as $key => $etnia) {
            $registro = \App\Models\Etnia::create([
                'nombre' => $etnia,
                'slug' => \Illuminate\Support\Str::slug($etnia),
                'active_at' => now(),
            ]);

            if(in_array($key, $gt)){
                $registro->paises()->syncWithoutDetaching([1 => ['active_at' => now()]]);
            } elseif(in_array($key, $comun)){
                $registro->paises()->syncWithoutDetaching([1 => ['active_at' => now()]]);
                $registro->paises()->syncWithoutDetaching([2 => ['active_at' => now()]]);
            }else{
                $registro->paises()->syncWithoutDetaching([2 => ['active_at' => now()]]);
            }
        }
    }
}
