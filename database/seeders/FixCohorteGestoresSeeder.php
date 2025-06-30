<?php

namespace Database\Seeders;

use App\Models\CohorteProyectoUser;
use App\Models\CoordinadorGestor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FixCohorteGestoresSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cohortePaisProyecto = 9;
        $idCoordinador = 388;

        $gestores = CohorteProyectoUser::where('cohorte_pais_proyecto_id', $cohortePaisProyecto)
            ->where(function ($query) {
                $query->where('rol', 'Gestor')
                      ->orWhere('rol', 'gestor');
            })
            ->get();

        foreach ($gestores as $gestor) {
            CoordinadorGestor::firstOrCreate([
                'coordinador_id' => $idCoordinador,
                'gestor_id' => $gestor->id,
                'cohorte_pais_proyecto_id' => $cohortePaisProyecto,
            ], [
                'active_at' => now()
            ]);
        }


    }
}
