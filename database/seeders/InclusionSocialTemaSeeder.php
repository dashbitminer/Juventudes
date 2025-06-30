<?php

namespace Database\Seeders;

use App\Models\InclusionSocialTema;
use Illuminate\Database\Seeder;
class InclusionSocialTemaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $values = [
            'Educación',
            'Salu',
            'Nutrición / Seguridad Alimentari',
            'Protección Socia',
            'Derechos Humano',
            'Géner',
            'Prevención y atención de la trata de persona',
            'Discapacidades',
        ];
                                    
        foreach ($values as $value) {
            $model = InclusionSocialTema::create([
                'nombre' => $value,
                'active_at' => now(),
            ]);

            $model->paises()->attach([1, 2, 3]);
        }
    }
}
