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
        Schema::create('cost_shares', function (Blueprint $table) {
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

            $table->text('descripcion_contribucion')->nullable();
            $table->double('monto')->nullable();

            $table->foreignId('pais_costshare_valoracion_id')->nullable()->constrained('pais_costshare_valoraciones');
            $table->text('documento_soporte')->nullable();
            $table->string('nombre_persona_registra');

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
        Schema::dropIfExists('cost_share');
    }
};
