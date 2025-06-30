<?php

namespace Database\Seeders;

use App\Models\Ciudad;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PerfilSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (User::all() as $user) {
            $user->perfil()->create([
                'ciudad_id' => Ciudad::all()->random()->id,
                'profile_photo_path' => 'https://via.placeholder.com/150',
                'direccion' => 'Ciudad de Guatemala',
                'comentario' => 'Comentario de prueba',
                'created_at' => now(),
                'created_by' => 1
            ]);
        }
    }
}
