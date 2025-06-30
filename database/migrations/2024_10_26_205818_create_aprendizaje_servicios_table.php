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
        Schema::create('aprendizaje_servicios', function (Blueprint $table) {
            $table->id();
            // $table->foreignId('pais_id')->constrained('paises');
            // $table->foreignId('proyecto_id')->constrained();
            // $table->foreignId('participante_id')->constrained();
            // $table->foreignId('cohorte_id')->constrained();
            $table->foreignId('directorio_id')->constrained();

            $table->text('programa_proyecto')->nullable();
            $table->foreignId('ciudad_id')->nullable();
            $table->string('comunidad')->nullable();
            $table->date('fecha_inicio_prevista')->nullable();
            $table->date('fecha_fin_prevista')->nullable();

            $table->string('otros_conocimientos')->nullable();
            $table->string('titulo_contribucion_cambio')->nullable();
            $table->string('objetivo_contribucion_cambio')->nullable();
            $table->string('acciones_contribucion_cambio')->nullable();
            $table->string('otros_comentarios')->nullable();

            $table->string('descripcion_otros_servicios_desarrollar')->nullable();
            $table->string('descripcion_habilidad_adquirir')->nullable();

            $table->date('fecha_fin_cambio');
            $table->date('fecha_inicio_cambio');

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
        Schema::dropIfExists('aprendizaje_servicios');
    }
};
