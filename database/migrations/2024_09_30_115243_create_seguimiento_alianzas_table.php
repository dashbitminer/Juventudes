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
        Schema::create('seguimiento_alianzas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('alianza_id')->constrained('alianzas');
            $table->date('fecha_modificacion_alianza');
            $table->string('nombre_contacto')->nullable();
            $table->string('telefono_contacto')->nullable();
            $table->string('email_contacto')->nullable();
            $table->foreignId('pais_proposito_alianza_id')->nullable()->constrained('pais_proposito_alianza');
            $table->text('otro_proposito_alianza')->nullable();
            $table->foreignId('modalidad_estrategia_alianza_pais_id')
                ->constrained('modalidad_estrategia_alianza_pais', 'id', 'fk_seg_modalidad_alianza_pais');
            $table->foreignId('objetivo_asistencia_alianza_pais_id')
                ->nullable()
                ->constrained('objetivo_asistencia_alianza_pais', 'id', 'fk_seg_objetivo_alianza_pais');
            $table->text('otro_objetivo_asistencia_alianza')->nullable();
            $table->text('motivo_modificacion_alianza')->nullable();
            $table->text('documento_respaldo')->nullable();
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
        Schema::dropIfExists('seguimiento_alianzas');
    }
};
