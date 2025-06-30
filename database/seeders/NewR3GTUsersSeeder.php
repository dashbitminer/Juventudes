<?php

namespace Database\Seeders;

use App\Models\Cohorte;
use App\Models\CohortePaisProyecto;
use App\Models\CohorteProyectoUser;
use App\Models\CoordinadorGestor;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use App\Models\SocioImplementadorUser;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class NewR3GTUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'R3.ACPDRO',
                'validador' => 'V3.GT',
                'validador_id' => 307,
                'cohortes' => [8, 9]
            ],
            [
                'name' => 'R3.CEIP',
                'validador' => 'V3.GT',
                'validador_id' => 307,
                'cohortes' => [8, 9]
            ],
            [
                'name' => 'R3.TN',
                'validador' => 'V3.GT',
                'validador_id' => 307,
                'cohortes' => [8, 9]
            ],
            [
                'name' => 'R3.ACBF',
                'validador' => 'V3.GT',
                'validador_id' => 307,
                'cohortes' => [8, 9]
            ],
        ];

        foreach ($users as $user) {

            $usuario = \App\Models\User::where('username', $user['name'])->first();

            foreach ($user['cohortes'] as $cohorte) {

                $cohorteProyectoUser = CohorteProyectoUser::firstOrCreate([
                    'user_id' => $usuario->id,
                    'cohorte_pais_proyecto_id' => $cohorte,
                    'rol' => 'registro R3',
                ], [
                    'active_at' => now(),
                ]);

                $validadorRecord = CohorteProyectoUser::where('user_id', $user['validador_id'])
                    ->where('cohorte_pais_proyecto_id', $cohorte)
                    ->first();

                CoordinadorGestor::create([
                    'cohorte_pais_proyecto_id' => $cohorte,
                    'coordinador_id' => $validadorRecord->id,
                    'gestor_id' => $cohorteProyectoUser->id,
                    'active_at' => now(),
                ]);


            }
        }
    }
}
