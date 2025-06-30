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

class NewR3UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'R3.GT',
                'email' => 'R3.GT@glasswing.org',
                'password' => 'Mgi79u9y0I',
                'socio' => 14,
                'validador' => 'V3.GT',
                'validador_id' => 307,
                'cohortes' => [8, 9]
            ],
            [
                'name' => 'R3.HN',
                'email' => 'R3.HN@glasswing.org',
                'password' => 'IDQbx1FynQ',
                'socio' => 15,
                'validador' => 'V3.HN',
                'validador_id' => 281,
                'cohortes' => [10, 11]
            ],
        ];

        foreach ($users as $user) {

            $usuario = \App\Models\User::where('username', $user['name'])->first();

            if(!$usuario){
                $usuario = \App\Models\User::create([
                    'name' => $user['name'],
                    'username' => $user['name'],
                    'email' => $user['email'],
                    'password' => bcrypt($user['password']),
                    'socio_implementador_id' => $user['socio'],
                    'active_at' => now(),
                ]);

                $usuario->forceFill([
                    'email_verified_at' => now(), //    $usuario->markEmailAsVerified();
                    'remember_token' => Str::random(10),
                ])->save();

                $usuario->assignRole('Registro R3');

                SocioImplementadorUser::create([
                    'user_id' => $usuario->id,
                    'socio_implementador_id' => $user['socio'],
                ]);
            }



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
