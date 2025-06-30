<?php

namespace Database\Seeders;

use App\Models\CohorteProyectoUser;
use App\Models\CoordinadorGestor;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class NuevosUsuariosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            ['name' => 'G.C08.TN.8', 'socio_id' => 6, 'pais' => 'Guatemala', 'password' => 'ydIC6kVVam', 'rol' => 'Gestor']
        ];

        foreach ($users as $user) {

            if (\App\Models\User::where('name', $user['name'])->exists()) {
                continue;
            }

            // 1. CREAR USUARIO

            $usuario = \App\Models\User::create([
                'username' => $user['name'],
                'name' => $user['name'],
                'email' => $user['name'] . '@glasswing.org',
                'email_verified_at' => now(),
                'password' => \Illuminate\Support\Facades\Hash::make($user['password']),
                'socio_implementador_id' => $user['socio_id'],
                'remember_token' => Str::random(10),
            ]);

            $usuario->forceFill([
                'email_verified_at' => now(), //    $usuario->markEmailAsVerified();
                'remember_token' => Str::random(10),
            ])->save();

            // 2. ASIGNAR ROL
            $usuario->assignRole($user['rol']);

            // 3. ASIGNAR SOCIO
            $usuario->sociosImplementadores()->sync($user["socio_id"]);

            // 4. DAR ACCESO AL USARIO AL PAIS PROYECTO COHORTE
            $usuario->cohorte()->syncWithoutDetaching([8 => ['rol' => $user['rol'], 'active_at' => now()]]);
            $usuario->cohorte()->syncWithoutDetaching([9 => ['rol' => $user['rol'], 'active_at' => now()]]);


            // 5. ASIGNAR PERMISOS
            // COORDINADOR PARA EL 8 ES 387
            // COORDINADOR PARA EL 9 ES 388

            $cohorteProeyctoUser = CohorteProyectoUser::where('user_id', $usuario->id)->where('cohorte_pais_proyecto_id', 8)->first();

            CoordinadorGestor::create([
                'coordinador_id' => 387,
                'gestor_id' => $cohorteProeyctoUser->id,
                'cohorte_pais_proyecto_id' => 8,
                'active_at' => now()
            ]);

            $cohorteProeyctoUser = CohorteProyectoUser::where('user_id', $usuario->id)->where('cohorte_pais_proyecto_id', 9)->first();

            CoordinadorGestor::create([
                'coordinador_id' => 388,
                'gestor_id' => $cohorteProeyctoUser->id,
                'cohorte_pais_proyecto_id' => 9,
                'active_at' => now()
            ]);


        }


    }
}
