<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EstadoRegistroSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $estados = [
            ['name' => 'Documentación pendiente', 'color' => 'gray', 'icon' => 'icon.pencil-square'],
            ['name' => 'Pendiente de revisión', 'color' => 'orange', 'icon' => 'icon.clock'],
            ['name' => 'Observado', 'color' => 'purple', 'icon' => 'icon.arrow-uturn-left'],
            ['name' => 'Validado', 'color' => 'green', 'icon' => 'icon.check'],
            ['name' => 'Rechazado', 'color' => 'red', 'icon' => 'icon.x-mark'],
        ];

        foreach ($estados as $estado) {

            \App\Models\EstadoRegistro::create([
                'nombre' => $estado['name'],
                'slug' => \Illuminate\Support\Str::slug($estado['name']),
                'color' => $estado['color'],
                'icon' => $estado['icon'],
                'active_at' => now(),
            ]);
        }
    }
}
