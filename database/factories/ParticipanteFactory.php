<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\App;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Participante>
 */
class ParticipanteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        return [
            'nombres' => $name = fake()->name(),
            'apellidos' => $lastName = fake()->lastName(),
            'slug' => Str::slug($name . ' ' . $lastName),
            'fecha_nacimiento' => fake()->date(),
            'nacionalidad' => fake()->numberBetween(1, 2),
            'estado_civil_id' => fake()->numberBetween(1, 5),
            //'discapacidad_id' => fake()->numberBetween(1, 6),
            //'grupo_perteneciente_id' => fake()->numberBetween(1, 7),
            //'etnia_id' => fake()->numberBetween(1, 7),
            //'comparte_responsabilidad_hijo_id' => fake()->numberBetween(1, 5),
            //'apoyo_hijo_id' => fake()->numberBetween(1, 4),
            //'proyecto_vida_id' => $proyectoVida = fake()->numberBetween(1, 4),
            'nivel_academico_id' => fake()->numberBetween(1, 15),
            'seccion_grado_id' => fake()->numberBetween(1, 8),
            'turno_estudio_id' => fake()->numberBetween(1, 6),
            'nivel_educativo_id' => fake()->numberBetween(1, 8),
            'nivel_educativo_alcanzado' => fake()->numberBetween(1, 9),
            'parentesco_id' => fake()->numberBetween(1, 5),
            'tipo_zona_residencia' => fake()->numberBetween(1, 2),
            'ciudad_id' => fake()->numberBetween(1, \App\Models\Ciudad::count()),
            'direccion' => fake()->address(),
            'colonia' => fake()->word(),
            'sexo' => fake()->numberBetween(1,2),
            'comunidad_linguistica' => fake()->word(),
            //'proyecto_vida_descripcion' => $proyectoVida == 4 ? fake()->sentence() : NULL,
            'tiene_hijos' => $hijos = fake()->boolean(),
            'cantidad_hijos' => $hijos ? fake()->numberBetween(1, 5) : NULL,
            'estudia_actualmente' => fake()->boolean(),
            'participo_actividades_glasswing' => $previaParticipacion = fake()->boolean(),
            'rol_participo' => $previaParticipacion ? fake()->numberBetween(1, 2) : NULL,
            'descripcion_participo' => $previaParticipacion ? fake()->sentence() : NULL,
            'documento_identidad' => fake()->unique()->randomNumber(8),
            'email' => fake()->unique()->safeEmail(),
            'telefono' => fake()->phoneNumber(),
            //'departamento_nacimiento_id' => fake()->numberBetween(1, 15),
            'municipio_nacimiento_id' => fake()->numberBetween(1, 45),
            "departamento_nacimiento_extranjero" => fake()->state(),
            "pais_nacimiento_extranjero" => fake()->country(),
            "municipio_nacimiento_extranjero" => fake()->city(),
            'nombre_beneficiario' => fake()->name(),
            'copia_documento_identidad' => fake()->imageUrl(),
            'copia_constancia_estudios' => fake()->imageUrl(),
            'consentimientos_inscripcion_programa' => fake()->imageUrl(),
            //'gestor_id' => fake()->numberBetween(1, 10),
            //'cohorte_id' => 1,
            'comentario_documento_identidad_upload' => fake()->sentence(),
            'comentario_copia_certificado_estudio_upload' => fake()->sentence(),
            'comentario_formulario_consentimiento_programa_upload' => fake()->sentence(),
        ];
    }
}
