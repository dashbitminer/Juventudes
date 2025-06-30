<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NewAdminUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cuentas = [
            [
                'name' => 'isaavedra',
                'email' => 'isaaedra@glasswing.org',
                'socio' => 1,
                'password' => bcrypt('XDQbog9XcU'),
            ],
            [
                'name' => 'tonyg',
                'email' => 'tonyg@glasswing.org',
                'socio' => 1,
                'password' => bcrypt('EYgj01Y9uL'),
            ],
        ];

        foreach ($cuentas as $cuenta) {
            $usuario = \App\Models\User::create([
                'name' => $cuenta['name'],
                'username' => $cuenta['name'],
                'active_at' => now(),
                'email' => $cuenta['email'],
                'socio_implementador_id' => $cuenta['socio'],
                'password' => $cuenta['password'],
            ]);

            $usuario->forceFill([
                'email_verified_at' => now(), //    $usuario->markEmailAsVerified();
                'remember_token' => \Illuminate\Support\Str::random(10),
            ])->save();

            $usuario->assignRole('Admin');

            \App\Models\SocioImplementadorUser::create([
                'user_id' => $usuario->id,
                'socio_implementador_id' => $cuenta['socio'],
            ]);

        }
    }
}
