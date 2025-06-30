<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CohorteParticipanteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (\App\Models\Participante::get() as $participante) {
            $participante->cohorte()->attach(\App\Models\Cohorte::inRandomOrder()->first()->id, [
                'comentario' => \Faker\Factory::create()->text(),
            ]);
        }
    }
}
