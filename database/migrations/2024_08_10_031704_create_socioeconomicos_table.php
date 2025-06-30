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
        Schema::create('socioeconomicos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('participante_id')->constrained('participantes');
            $table->tinyInteger('miembros_familia_vives')->nullable()->comment('¿Con cuántos miembros de tu familia vives en tu casa?');
            $table->tinyInteger('cuartos_en_hogar')->nullable()->comment('¿Cuántos cuartos tiene tu hogar?');
            $table->tinyInteger('cuartos_como_dormitorios')->nullable()->comment('¿Cuántos de esos cuartos se usan como habitación para dormir?');
            $table->tinyInteger('focos_electricos_hogar')->nullable()->comment('¿Cuántos focos o bombillos eléctricos hay en tu hogar?');
            $table->tinyInteger('participante_migrado_retornado')->nullable()->comment('¿La persona participante expresa haber migrado y haber sido retornada al país? 1: si, 2: no, 3: Prefiere no responder');
            $table->tinyInteger('participante_miembro_hogar_migrado')->nullable()->comment('¿La persona participante expresa haber migrado y haber sido retornada al país? 1: si, 2: no, 3: Prefiere no responder');
            $table->tinyInteger('hogar_personas_condiciones_trabajar')->nullable()->comment('De las personas que componen tu hogar, ¿cuántas están en edad y condición de trabajar?');
            $table->tinyInteger('trabajan_con_ingresos_fijos')->nullable()->comment('De las personas de tu hogar que trabajan, ¿cuántas tienen ingresos fijos?');
            $table->tinyInteger('contratadas_permanentemente')->nullable()->comment('¿cuántas están contratadas de manera permanente?');
            $table->tinyInteger('contratadas_temporalmente')->nullable()->comment('¿cuántas están contratadas de manera temporal?');
            $table->tinyInteger('sentido_inseguro_en_comunidad')->nullable()->comment('¿Te has sentido inseguro/a en tu comunidad durante el último año? 1: si, 2: no, 3: Prefiere no responder');
            $table->tinyInteger('victima_violencia')->nullable()->comment('¿Has sido víctima de algún tipo de violencia en los últimos seis meses? (Violencia física, emocional, sexual, etc.) 1: si, 2: no, 3: Prefiere no responder');
            $table->tinyInteger('conocido_violencia_genero')->nullable()->comment('¿Conoces a alguien en tu comunidad que haya sido víctima de violencia de género? 1: si, 2: no, 3: Prefiere no responder');
            $table->tinyInteger('espacios_seguros_para_victimas')->nullable()->comment('¿Hay espacios seguros en tu comunidad donde puedas buscar ayuda si eres víctima de violencia? 1: si, 2: no, 3: Prefiere no responder');
            $table->tinyInteger('participas_proyecto_recibir_bonos')->nullable()->comment('¿Actualmente participas en algún proyecto u ONG del cual recibas bonos o beneficios económicos?1: si, 2: no; 3: no sabe');
            $table->string('proyecto_ong_bonos')->nullable()->comment('¿Cuál es el nombre del proyecto u ONG del cual recibes bonos o beneficios económicos?');
            $table->tinyInteger('familiar_participa_proyecto_recibir_bonos')->nullable()->comment('¿Algún miembro de tu familia participa en algún proyecto u ONG del cual reciba beneficios económicos? 1: si, 2: no; 3: no sabe');
            $table->string('familiar_proyecto_ong_bonos')->nullable()->comment('¿Cuál es el nombre del proyecto u ONG del cual recibe bonos o beneficios económicos?');
            $table->text('informacion_relevante')->nullable()->comment('Cualquier información relevante que consideres puedes comentar:');

            $table->datetime('readonly_at')->nullable();
            $table->integer('readonly_by')->nullable();
            //pdf
            $table->text('pdf')->nullable();

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
        Schema::dropIfExists('socioeconomicos');
    }
};
