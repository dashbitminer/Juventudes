<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


class FinancieroRoleSeederClass extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        \App\Models\Role::firstOrCreate(['name' => 'Financiero']);

        $password = 'glasswing';
        $usuario = \App\Models\User::create([
            'username' => 'financiero',
            'name' => 'financierotest',
            'email' => 'financierotest' . '@glasswing.org',
            'email_verified_at' => now(),
            'password' => \Illuminate\Support\Facades\Hash::make($password),
            'socio_implementador_id' => 1,
            'remember_token' => \Illuminate\Support\Str::random(10),
        ]);

        $usuario->forceFill([
            'email_verified_at' => now(), //    $usuario->markEmailAsVerified();
            'remember_token' => \Illuminate\Support\Str::random(10),
        ])->save();

        $usuario->assignRole('Financiero');

         \App\Models\CohorteProyectoUser::create([
            'user_id' => $usuario->id,
            'cohorte_pais_proyecto_id' => 6, // JLI COHORTE 7
            'rol' => 'financiero',
            'active_at' => now(),
         ]);

    }
}
