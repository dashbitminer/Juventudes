<?php

namespace Database\Seeders;

use App\Models\User;
use App\Enums\RolCohorte;
use Illuminate\Database\Seeder;
use App\Models\CohorteSocioUser;
use App\Models\CoordinadorGestor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CoordinadorGestorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all users with role 'coordinador'
        $coordinadores = User::role('coordinador')->get();

        // Get all users with role 'gestor'
        $gestores = User::role('gestor')->get();

        foreach ($coordinadores as $coordinador) {
            foreach ($gestores as $gestor) {
                CoordinadorGestor::create([
                    'gestor_id' => $gestor->id,
                    'coordinador_id' => $coordinador->id,
                    'cohorte_pais_proyecto_id' => 1,
                    'active_at' => now(),
                ]);
            }
        }


    }
}
