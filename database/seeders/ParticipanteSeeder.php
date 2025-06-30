<?php

namespace Database\Seeders;

use App\Models\Estado;
use App\Models\EstadoRegistro;
use App\Models\Participante;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ParticipanteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Participante::factory(90)->create();

        foreach (Participante::all() as $participante) {

            // Create random estados for each participante
            $participante->estados_registros()->attach(EstadoRegistro::all()->random()->id);

            // Create random discapacidades for each participante
            foreach (range(1, rand(1, 3)) as $index) {
                $participante->discapacidades()->attach(rand(1, 6));
            }

            // Create random grupos pertenecientes for each participante
            // foreach (range(1, rand(1, 3)) as $index) {
            //     $participante->gruposPertenecientes()->attach(rand(1, 7));
            // }

            // Create random responsablidad hijo for each participante
            foreach (range(1, rand(1, 3)) as $index) {
                $participante->responsabilidadHijos()->attach(rand(1, 3));
            }

            // Create random apoyo hijo for each participante
            foreach (range(1, rand(1, 3)) as $index) {
                $participante->apoyohijos()->attach(rand(1, 3));
            }

            // Create random etnias for each participante
            // foreach (range(1, rand(1, 3)) as $index) {
            //     $participante->etnias()->attach(rand(1, 3));
            // }


            foreach (range(1, rand(1, 3)) as $index) {
                $participante->proyectoVida()->attach(rand(1, 4), [
                    'comentario' => \Faker\Factory::create()->text(),
                ]);
            }

        }




    }
}
