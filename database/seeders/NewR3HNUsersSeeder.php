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

class NewR3HNUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'R3.CRH',
                'validador' => 'V3.HN',
                'validador_id' => 281,
                'cohortes' => [10, 11]
            ],
            [
                'name' => 'R3.AFNV',
                'validador' => 'V3.HN',
                'validador_id' => 281,
                'cohortes' => [10, 11]
            ],
            [
                'name' => 'R3.CASM',
                'validador' => 'V3.HN',
                'validador_id' => 281,
                'cohortes' => [10, 11]
            ],
            [
                'name' => 'R3.FNPDH',
                'validador' => 'V3.HN',
                'validador_id' => 281,
                'cohortes' => [10, 11]
            ],
            [
                'name' => 'R3.HN',
                'validador' => 'V3.HN',
                'validador_id' => 281,
                'cohortes' => [10, 11]
            ],
            /*[
                'name' => 'R3.HN',
                'email' => 'R3.HN@glasswing.org',
                'password' => 'IDQbx1FynQ',
                'socio' => 15,
                'validador' => 'V3.HN',
                'validador_id' => 281,
                'cohortes' => [10, 11]
            ],*/
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

               // dd($validadorRecord, $user['validador_id'], $cohorte);

                CoordinadorGestor::create([
                    'cohorte_pais_proyecto_id' => $cohorte,
                    'coordinador_id' => $validadorRecord->id,
                    'gestor_id' => $cohorteProyectoUser->id,
                    //'coordinador_gestor_id' => $validadorRecord->id,
                    'active_at' => now(),
                ]);


            }
        }
    }
}
