<?php

namespace Database\Seeders;

use App\Models\CohortePaisProyecto;
use App\Models\CohorteProyectoUser;
use App\Models\CoordinadorGestor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FixCohortePaisProyectoV4 extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        /**
         * GUATEMALA
         */


        $cohorte5 = CohorteProyectoUser::firstOrCreate([
            'cohorte_pais_proyecto_id' => 2, //cohorte 5
            'user_id' => 308,
        ], [
            'rol' => 'Validación R4',
            'active_at' => now(),
        ]);

        $gestores5 = CohorteProyectoUser::where("rol", "gestor")
        ->where("cohorte_pais_proyecto_id", 2)
        ->get();

        foreach ($gestores5 as $gestor) {
            CoordinadorGestor::firstOrCreate([
                'coordinador_id' => $cohorte5->id,
                'gestor_id' => $gestor->id,
                'cohorte_pais_proyecto_id' => 2,
            ], [
                'active_at' => now()
            ]);
         }



        // --------------------------------------------

        $cohorte6 = CohorteProyectoUser::firstOrCreate([
            'cohorte_pais_proyecto_id' => 5, //cohorte 6
            'user_id' => 308,
        ], [
            'rol' => 'Validación R4',
            'active_at' => now(),
        ]);

        $gestores6 = CohorteProyectoUser::where("rol", "gestor")
        ->where("cohorte_pais_proyecto_id", 5)
        ->get();

        foreach ($gestores6 as $gestor) {
           CoordinadorGestor::firstOrCreate([
               'coordinador_id' => $cohorte6->id,
               'gestor_id' => $gestor->id,
               'cohorte_pais_proyecto_id' => 5,
           ], [
               'active_at' => now()
           ]);
        }


        // --------------------------------------------

        $cohorte7 = CohorteProyectoUser::firstOrCreate([
            'cohorte_pais_proyecto_id' => 6, // cohorte 7
            'user_id' => 308,
        ], [
            'rol' => 'Validación R4',
            'active_at' => now(),
        ]);

        $gestores7 = CohorteProyectoUser::where("rol", "gestor")
        ->where("cohorte_pais_proyecto_id", 6)
        ->get();

        foreach ($gestores7 as $gestor) {
           CoordinadorGestor::firstOrCreate([
               'coordinador_id' => $cohorte7->id,
               'gestor_id' => $gestor->id,
               'cohorte_pais_proyecto_id' => 6,
           ], [
               'active_at' => now()
           ]);
        }


         /**
         * HONDURAS
         * -- cohorte 5 es id 3,
        * -- cohorte 6 es id = 4
        * -- cohorte 7 es id 7
         */


         $cohorte5 = CohorteProyectoUser::firstOrCreate([
            'cohorte_pais_proyecto_id' => 3, //cohorte 5
            'user_id' => 282,
        ], [
            'rol' => 'Validación R4',
            'active_at' => now(),
        ]);

        $gestores5 = CohorteProyectoUser::where("rol", "gestor")
        ->where("cohorte_pais_proyecto_id", 3)
        ->get();

        foreach ($gestores5 as $gestor) {
            CoordinadorGestor::firstOrCreate([
                'coordinador_id' => $cohorte5->id,
                'gestor_id' => $gestor->id,
                'cohorte_pais_proyecto_id' => 3,
            ], [
                'active_at' => now()
            ]);
         }

        // --------------------------------------------

        $cohorte6 = CohorteProyectoUser::firstOrCreate([
            'cohorte_pais_proyecto_id' => 4, //cohorte 6
            'user_id' => 282,
        ], [
            'rol' => 'Validación R4',
            'active_at' => now(),
        ]);

        $gestores6 = CohorteProyectoUser::where("rol", "gestor")
        ->where("cohorte_pais_proyecto_id", 4)
        ->get();

        foreach ($gestores6 as $gestor) {
           CoordinadorGestor::firstOrCreate([
               'coordinador_id' => $cohorte6->id,
               'gestor_id' => $gestor->id,
               'cohorte_pais_proyecto_id' => 4,
           ], [
               'active_at' => now()
           ]);
        }

        // --------------------------------------------

        $cohorte7 = CohorteProyectoUser::firstOrCreate([
            'cohorte_pais_proyecto_id' => 7, // cohorte 7
            'user_id' => 282,
        ], [
            'rol' => 'Validación R4',
            'active_at' => now(),
        ]);

        $gestores7 = CohorteProyectoUser::where("rol", "gestor")
        ->where("cohorte_pais_proyecto_id", 7)
        ->get();

        foreach ($gestores7 as $gestor) {
           CoordinadorGestor::firstOrCreate([
               'coordinador_id' => $cohorte7->id,
               'gestor_id' => $gestor->id,
               'cohorte_pais_proyecto_id' => 7,
           ], [
               'active_at' => now()
           ]);
        }

    }
}
