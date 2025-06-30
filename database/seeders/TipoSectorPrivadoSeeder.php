<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TipoSectorPrivadoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tipos = [
            ['name' => 'Local', 'comment' => ''],
            ['name' => 'Nacional', 'comment' => ''],
            ['name' => 'Departamental', 'comment' => ''],
            ['name' => 'Internacional', 'comment' => ''],
            ['name' => 'Entidades comerciales con fines de lucro', 'comment' => '(excluidas instituciones financieras y empresas sociales)'],
            ['name' => 'Instituciones financieras privadas', 'comment' => '(excluidas empresas sociales)'],
            ['name' => 'Empresas sociales privadas', 'comment' => ''],
            ['name' => 'Fundaciones corporativas y entidades filantrópicas corporativas', 'comment' => ''],
            ['name' => 'Fundaciones privadas que otorgan subvenciones', 'comment' => ''],
            ['name' => 'Asociaciones empresariales, comerciales e industriales', 'comment' => '(incluidas las Cámaras de Comercio)'],
            ['name' => 'Cooperativas Privadas', 'comment' => ''],
            ['name' => 'Otro', 'comment' => ''],
        ];

        foreach ($tipos as $tipo) {
            \App\Models\TipoSectorPrivado::create([
                'nombre' => $tipo["name"],
                'comentario' => $tipo["comment"],
                'active_at' => now(),
            ]);
        }

        \App\Models\TipoSectorPrivado::all()->each(function ($tipoSectorPrivado) {
            $tipoSectorPrivado->pais()->attach([1,2,3], ['active_at' => now()]);
        });
    }
}
