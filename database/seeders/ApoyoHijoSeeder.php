<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ApoyoHijoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $apoyo_hijo = [
            'Si, con familiares',
            'Si, con amistades',
            'Si, pago a alguien para que me ayude',
            'No tengo apoyo ',
        ];

        foreach ($apoyo_hijo as $apoyo_hijo) {
            \App\Models\ApoyoHijo::create([
                'nombre' => $apoyo_hijo,
               // 'slug' => \Illuminate\Support\Str::slug($apoyo_hijo),
                'active_at' => now(),
            ]);
        }
    }
}
