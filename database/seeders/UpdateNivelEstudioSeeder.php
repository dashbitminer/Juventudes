<?php

namespace Database\Seeders;

use App\Models\NivelAcademico;
use App\Models\NivelEducativo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UpdateNivelEstudioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $niveles = NivelAcademico::all();
        //NivelEducativo::where("id" > 2)->forceDelete();
        foreach ($niveles as $nivel) {
            NivelEducativo::create([
                'nombre' => $nivel->nombre,
                'slug' => $nivel->slug,
                'categoria' => $nivel->categoria,
                'active_at' => $nivel->active_at,
            ]);
        }
    }
}
