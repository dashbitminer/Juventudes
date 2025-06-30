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
    Schema::create('apalancamientos', function (Blueprint $table) {
        $table->id();
        $table->string('nombre_organizacion');
        $table->integer('tipo_organizacion')->comment('Tipo Organizacion (Nuevo = 0, Existente = 1)');
        $table->foreignId('gestor_id')->constrained('users'); 
        $table->foreignId('socio_implementador_id')->constrained('socios_implementadores');
        $table->foreignId('ciudad_id')->constrained('ciudades', 'id');
        $table->foreignId('pais_tipo_sector_id')->constrained('pais_tipo_sector');
        
        $table->foreignId('pais_tipo_sector_publico_id')->nullable()->constrained('pais_tipo_sector_publico');
        $table->foreignId('pais_tipo_sector_privado_id')->nullable()->constrained('pais_tipo_sector_privado');
        $table->string('otro_tipo_sector_privado')->nullable();
        $table->foreignId('pais_origen_empresa_privada_id')->nullable()->constrained('pais_origen_empresa_privada');
        $table->foreignId('pais_tamano_empresa_privada_id')->nullable()->constrained('pais_tamano_empresa_privada');
        $table->foreignId('pais_tipo_sector_comunitaria_id')->nullable()->constrained('pais_tipo_sector_comunitaria');
        $table->foreignId('pais_tipo_sector_academica_id')->nullable()->constrained('pais_tipo_sector_academica');

        $table->foreignId('pais_tipo_recurso_id')->constrained('pais_tipo_recurso');
        $table->integer('tipo_recurso_especie')->comment('Tipo Recurso Especie (Nuevo = 0, Usado = 1)');
        $table->foreignId('pais_origen_recurso_id')->constrained('pais_origen_recurso');
        $table->foreignId('pais_fuente_recurso_id')->constrained('pais_fuente_recurso');

        $table->foreignId('modalidad_estrategia_alianza_pais_id')
                ->constrained('modalidad_estrategia_alianza_pais', 'id', 'fk_modalidad_apalancamiento_pais');

        $table->foreignId('objetivo_asistencia_alianza_pais_id')
            ->nullable()
            ->constrained('objetivo_asistencia_alianza_pais', 'id', 'fk_objetivo_apalancamiento_pais');
        $table->text('otro_objetivo_asistencia_alianza')->nullable();
        
        $table->text('concepto_recurso')->nullable();
        $table->double('monto_apalancado')->nullable();

        $table->text('nombre_persona_registra')->nullable();

        $table->text('documento_respaldo')->nullable();
        $table->text('comentario')->nullable();

        $table->timestamp('active_at')->nullable();
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
        Schema::dropIfExists('apalancamientos');
    }
};
