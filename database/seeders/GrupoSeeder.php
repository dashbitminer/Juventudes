<?php

namespace Database\Seeders;

use Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class GrupoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $grupos = [
            'Grupo 1',
            'Grupo 2',
            'Grupo 3',
            'Grupo 4',
            'Grupo 5',
            'Grupo 6',
            'Grupo 7',
            'Grupo 8',
            'Grupo 9',
            'Grupo 10',
            'Grupo 11',
            'Grupo 12',
            'Grupo 13',
            'Grupo 14',
            'Grupo 15',
            'Grupo 16',
            'Grupo 17',
            'Grupo 18',
            'Grupo 19',
            'Grupo 20',
            'Grupo 21',
            'Grupo 22',
            'Grupo 23',
            'Grupo 24',
            'Grupo 25',
            'Grupo 26',
            'Grupo 27',
            'Grupo 28',
            'Grupo 29',
            'Grupo 30',
            'Grupo 31',
            'Grupo 32',
            'Grupo 33',
            'Grupo 34',
            'Grupo 35',
            'Grupo 36',
            'Grupo 37',
            'Grupo 38',
            'Grupo 39',
            'Grupo 40',
            'Grupo 41',
            'Grupo 42',
            'Grupo 43',
            'Grupo 44',
            'Grupo 45',
            'Grupo 46',
            'Grupo 47',
            'Grupo 48',
            'Grupo 49',
            'Grupo 50',
            'Grupo 51',
            'Grupo 52',
            'Grupo 53',
            'Grupo 54',
            'Grupo 55',
            'Grupo 56',
            'Grupo 57',
            'Grupo 58',
            'Grupo 59',
            'Grupo 60',
        ];

        foreach ($grupos as $grupo) {
            \App\Models\Grupo::create([
                'nombre' => $grupo,
                'slug' => \Str::slug($grupo),
                'active_at' => now(),
                'comentario' => 'Comentario de ' . $grupo,
            ]);
        }
    }
}
