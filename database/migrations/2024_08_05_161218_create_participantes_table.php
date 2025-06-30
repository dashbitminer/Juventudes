<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('participantes', function (Blueprint $table) {
            $table->id();
            $table->string('nombres');
            $table->string('apellidos');
            $table->string('slug');
            $table->date("fecha_nacimiento")->nullable();
            $table->tinyInteger('nacionalidad')->nullable()->default(null)->comment('1:Nacional, 2:Extranjero');
            $table->foreignId('estado_civil_id')->nullable()->constrained('estados_civiles')->nullable();
            //$table->foreignId('discapacidad_id')->constrained('discapacidades')->comment('¿Posee algún tipo de discapacidad?');
            //$table->unsignedBigInteger('grupo_perteneciente_id')->comment('¿A cuál de los siguientes grupos cree que pertenece?');
            //$table->foreignId('etnia_id')->constrained('etnias')->comment('¿A qué pueblo indígena o comunidad étnica perteneces?');
            //$table->unsignedBigInteger('comparte_responsabilidad_hijo_id')->comment("Con quien o quienes comparte paternidad/maternidad");
            //$table->unsignedBigInteger('apoyo_hijo_id')->comment("Apoyo para cuidar a sus hijos o hijas mientras participas en el programa");
            // $table->foreignId('proyecto_vida_id')->constrained('proyecto_vidas')->comment('¿Cuál es tu proyecto de vida principal? Marca la opción que mejor describa tu objetivo:');

            $table->boolean('estudia_actualmente')->nullable()->comment('1:Si, 0:No');
            $table->foreignId('nivel_academico_id')->nullable()->constrained('nivel_academicos')->comment("Nivel académico actual");
            $table->foreignId('seccion_grado_id')->nullable()->constrained('seccion_grados')->comment("Sección del grado actual");
            $table->foreignId('turno_estudio_id')->nullable()->constrained('turno_estudios')->comment("Turno o jornada en la que estudia");
            $table->foreignId('nivel_educativo_id')->nullable()->constrained('nivel_educativos')->comment("Último nivel educativo alcanzado");
            $table->smallInteger('nivel_educativo_alcanzado')->nullable()->comment("Si es primaria o secundaria indicar grado, de 1 a 9");

            $table->foreignId('parentesco_id')->nullable()->constrained('parentescos')->comment('6.	Parentesco de persona que asignan como beneficiaria de cuenta bancaria en caso de fallecimiento');
            $table->string('parentesco_otro')->nullable()->comment('Parentesco de persona que asignan como beneficiaria de cuenta bancaria en caso de fallecimiento (Otro)');

            $table->tinyInteger('tipo_zona_residencia')->nullable()->comment('1:Urbana, 2:Rural');
            $table->text('direccion')->nullable()->comment('Dirección completa con puntos de referencia');
            $table->foreignId('ciudad_id')->nullable()->constrained('ciudades');
            $table->text('colonia')->nullable()->comment('Colonia o barrio donde reside');
            $table->tinyInteger('sexo')->nullable()->comment('1:Femenino, 2:Masculino');
            $table->string('comunidad_linguistica')->nullable()->nullable();
            $table->text('proyecto_vida_descripcion')->nullable();
            $table->boolean('tiene_hijos')->nullable()->comment('1:Si, 0:No');
            $table->string('cantidad_hijos')->nullable();
            $table->boolean('participo_actividades_glasswing')->nullable()->comment('1:Si, 0:No');
            $table->tinyInteger('rol_participo')->nullable()->comment('1:Voluntario/voluntaria, 2:Participante');
            $table->string('descripcion_participo')->nullable()->comment('¿En qué participó?');


            // BANCARIZACIÓN
            $table->string('documento_identidad')->nullable()->comment('Número de documento de identidad de participante para bancarización');
            $table->string('email')->nullable()->comment('2.	Correo electrónico de participante para bancarización');
            $table->string('telefono')->nullable()->comment('3.	Teléfono de participante para bancarización');

            //$table->foreignId('departamento_nacimiento_id')->nullable()->comment('4.	Departamento de nacimiento para bancarización');
            $table->foreignId('municipio_nacimiento_id')->nullable()->constrained('ciudades')->nullable()->comment('4.	Municipio de nacimiento para bancarización');

            $table->string('pais_nacimiento_extranjero')->nullable()->comment('4.	País de nacimiento para bancarización (En caso de ser extranjero)');
            $table->string('departamento_nacimiento_extranjero')->nullable()->comment('4.	Departamento de nacimiento para bancarización (En caso de ser extranjero)');
            $table->string('municipio_nacimiento_extranjero')->nullable()->comment('4.	Municipio de nacimiento para bancarización (En caso de ser extranjero)');

            $table->string('nombre_beneficiario')->nullable()->comment('5.	Nombre completo de persona que asignan como beneficiaria de cuenta bancaria en caso de fallecimiento (Persona mayor de edad)');

            //DOCUMENTOS
            $table->string('copia_documento_identidad')->nullable()->comment('Copia de documento de identidad seleccionado de participante (URL de archivo subido)');
            $table->string('copia_constancia_estudios')->nullable()->comment('Copia de certificado o constancia de estudios (URL de archivo subido)');
            $table->string('consentimientos_inscripcion_programa')->nullable()->comment('Formulario de consentimientos y/o asentimientos para inscripción al programa)');
            $table->text('comentario_documento_identidad_upload')->nullable();
            $table->text('comentario_copia_certificado_estudio_upload')->nullable();
            $table->text('comentario_formulario_consentimiento_programa_upload')->nullable();
            //pdf
            $table->text('pdf')->nullable();


            $table->foreignId('gestor_id')->nullable()->constrained('users');

            $table->datetime('readonly_at')->nullable();
            $table->integer('readonly_by')->nullable();

            $table->timestamps();
            $table->softDeletes();
            $table->integer('created_by')->nullable()->default(null);
            $table->integer('updated_by')->nullable()->default(null);
            $table->integer('deleted_by')->nullable()->default(null);


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('participantes');
    }
};
