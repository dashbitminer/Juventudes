<?php

namespace Database\Seeders;

use App\Models\SectorProductivo;
use Illuminate\Database\Seeder;
class SectorProductivoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $values = [
            'Academia Internacional',
            'Academia Nacional',
            'Asociación',
            'Fundación',
            'Gobierno Central',
            'Gobiertno Municipal',
            'Organización',
            'Privado',
            'Privado ',
            'Privado A&B',
            'Privado Formación',
            'Privado Telecom',
            'Publico-Privado'
        ];
                                    
        foreach ($values as $value) {
            $model = SectorProductivo::create([
                'nombre' => $value,
                'active_at' => now(),
            ]);

            $model->paises()->attach([1, 2, 3]);
        }
    }
}
