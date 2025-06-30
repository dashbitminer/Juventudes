<?php

namespace Database\Seeders;

use App\Models\CohortePaisProyecto;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CohorteProyectoUser;

class FinancieroAccountsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //CohorteProyectoUser with cohortePaisProyecto relation where cohortePaisProyecto relation with paisProyecto id is 2
        \App\Models\Role::firstOrCreate(['name' => 'Financiero']);

        $password = 'TvhMpiU8iz';
        $usuariojli = \App\Models\User::create([
            'username' => 'FIN.JLI.GT',
            'name' => 'FIN.JLI.GT',
            'email' => 'FIN.JLI.GT' . '@glasswing.org',
            'email_verified_at' => now(),
            'password' => \Illuminate\Support\Facades\Hash::make($password),
            'socio_implementador_id' => 1,
            'remember_token' => \Illuminate\Support\Str::random(10),
        ]);

        $usuariojli->forceFill([
            'email_verified_at' => now(), //    $usuario->markEmailAsVerified();
            'remember_token' => \Illuminate\Support\Str::random(10),
        ])->save();

        $usuariojli->assignRole('Financiero');


        $cohortes = CohortePaisProyecto::where('pais_proyecto_id', 2)->get();

        foreach ($cohortes as $cohorte) {
            \App\Models\CohorteProyectoUser::create([
                'user_id' => $usuariojli->id,
                'cohorte_pais_proyecto_id' => $cohorte->id,
                'rol' => 'financiero',
                'active_at' => now(),
            ]);
        }


        $password = 'o5iw3PHFfp';
        $usuariojli = \App\Models\User::create([
            'username' => 'FIN.JLI.HN',
            'name' => 'FIN.JLI.HN',
            'email' => 'FIN.JLI.HN' . '@glasswing.org',
            'email_verified_at' => now(),
            'password' => \Illuminate\Support\Facades\Hash::make($password),
            'socio_implementador_id' => 1,
            'remember_token' => \Illuminate\Support\Str::random(10),
        ]);

        $usuariojli->forceFill([
            'email_verified_at' => now(), //    $usuario->markEmailAsVerified();
            'remember_token' => \Illuminate\Support\Str::random(10),
        ])->save();

        $usuariojli->assignRole('Financiero');

        $cohortes = CohortePaisProyecto::where('pais_proyecto_id', 3)->get();

        foreach ($cohortes as $cohorte) {
            \App\Models\CohorteProyectoUser::create([
                'user_id' => $usuariojli->id,
                'cohorte_pais_proyecto_id' => $cohorte->id,
                'rol' => 'financiero',
                'active_at' => now(),
            ]);
        }





    }
}
