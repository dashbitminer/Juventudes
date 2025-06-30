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
        Schema::create('alianzas', function (Blueprint $table) {
            $table->id();
            //$table->foreignId('user_id')->constrained();
            $table->string('nombre_organizacion');
            $table->foreignId('gestor_id')->constrained('users', 'id', 'fk_gestor');
            $table->foreignId('socio_implementador_id')->constrained('socios_implementadores', 'id');
            $table->foreignId('pais_organizacion_alianza_id')->constrained('pais_organizacion_alianza', 'id', 'fk_organizacion_alianza_pais');
            $table->foreignId('ciudad_id')->constrained('ciudades', 'id');
            $table->foreignId('pais_tipo_sector_id')->constrained('pais_tipo_sector', 'id', 'fk_pais_tipo_sector');
            $table->foreignId('pais_tipo_sector_publico_id')->nullable()->constrained('pais_tipo_sector_publico', 'id', 'fk_sector_publico');
            $table->foreignId('pais_tipo_sector_privado_id')->nullable()->constrained('pais_tipo_sector_privado', 'id', 'fk_sector_privado');
            $table->string('otro_tipo_sector_privado')->nullable();
            $table->foreignId('pais_origen_empresa_privada_id')->nullable()->constrained('pais_origen_empresa_privada');
            $table->foreignId('pais_tamano_empresa_privada_id')->nullable()->constrained('pais_tamano_empresa_privada');
            $table->foreignId('pais_tipo_sector_comunitaria_id')->nullable()->constrained('pais_tipo_sector_comunitaria');
            $table->foreignId('pais_tipo_sector_academica_id')->nullable()->constrained('pais_tipo_sector_academica');
            $table->string('nombre_contacto');
            $table->string('telefono_contacto');
            $table->string('email_contacto');
            $table->foreignId('pais_tipo_alianza_id')->constrained('pais_tipo_alianza');
            $table->text('otros_tipo_alianza')->nullable();
            $table->date('fecha_inicio')->nullable();
            $table->date('fecha_fin_tentativa')->nullable();
            $table->foreignId('pais_proposito_alianza_id')->nullable()->constrained('pais_proposito_alianza');
            $table->text('otro_proposito_alianza')->nullable();
            $table->foreignId('modalidad_estrategia_alianza_pais_id')
                ->constrained('modalidad_estrategia_alianza_pais', 'id', 'fk_modalidad_alianza_pais');
            $table->foreignId('objetivo_asistencia_alianza_pais_id')
                ->nullable()
                ->constrained('objetivo_asistencia_alianza_pais', 'id', 'fk_objetivo_alianza_pais');
            $table->text('otro_objetivo_asistencia_alianza')->nullable();
            $table->text('impacto_previsto_alianza')->nullable();
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
        Schema::dropIfExists('alianzas');
    }
};
