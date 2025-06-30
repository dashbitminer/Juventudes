<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CasaDispositivoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['nombre' => 'Nevera/Refrigeradora', 'comentario' => null],
            ['nombre' => 'Lavadora', 'comentario' => null],
            ['nombre' => 'Televisión (TV)', 'comentario' => null],
            ['nombre' => 'Moto', 'comentario' => null],
            ['nombre' => 'Computadora', 'comentario' => null],
            ['nombre' => 'Carro (vehículo automotor de 4 ruedas)', 'comentario' => null],
            ['nombre' => 'Lancha con motor', 'comentario' => null],
            ['nombre' => 'Televisión por cable', 'comentario' => null],
            ['nombre' => 'Plancha', 'comentario' => null],
            ['nombre' => 'Licuadora', 'comentario' => null],
            ['nombre' => 'Parcela para cultivar', 'comentario' => null],
            ['nombre' => 'Cafetera eléctrica', 'comentario' => null],
            ['nombre' => 'Internet residencial', 'comentario' => '(cuentas con wifi a la que puedes conectar cualquier dispositivo)'],
            ['nombre' => 'Internet móvil', 'comentario' => '(debes hacer recargas de celular)'],
            ['nombre' => 'Acceso de energía eléctrica','comentario' => null],
            ['nombre' => 'Dispositivos móviles (Teléfono o Tablet)','comentario' => null],
        ];

        foreach ($data as $row) {
            \App\Models\CasaDispositivo::create([
                'nombre' => $row['nombre'],
                'comentario' => $row['comentario'],
                'slug' => Str::slug($row['nombre']),
                'active_at' => now(),
            ]);
        }
    }
}
