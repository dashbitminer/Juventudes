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
        Schema::create('practica_empleabilidad', function (Blueprint $table) {
            $table->id();

            // $table->foreignId('pais_id')
            // ->constrained('paises', 'id', 'fk_pra_empleoabilidad_pais');
            // $table->foreignId('cohorte_id')->nullable()
            //     ->constrained('cohortes', 'id', 'fk_empleabilidad_cohorte');

            /* Se creo una migracion para agregar cohorte_participante_proyecto_id
               add_cohorte_participante_proyecto_to_practica_empleabilidad */

            // $table->foreignId('cohorte_participante_proyecto_id')->nullable()
            //     ->constrained('cohorte_participante_proyecto', 'id', 'fk_empleabilidad_cohorte_participante_proyecto');

            //$table->foreignId('participante_id')->constrained('participantes')->nullable();

            $table->boolean('cambiar_organizacion')->default(false);
            $table->foreignId('pais_motivo_cambio_organizacion_id')->nullable()
                ->constrained('pais_motivo_cambio_organizacion', 'id', 'fk_pais_motivo_cambio_practica');
            $table->foreignId('directorio_id')->constrained('directorios')->nullable();
            $table->text('motivo_cambio')->nullable();
            $table->text('programa_proyecto')->nullable();
            $table->foreignId('ciudad_id')->nullable();
            $table->string('comunidad')->nullable();
            $table->date('fecha_inicio_prevista')->nullable();
            $table->date('fecha_fin_prevista')->nullable();
            $table->text('otros_conocimientos')->nullable();
            $table->text('descripciones')->nullable();
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
        Schema::dropIfExists('practica_empleabilidad');
    }
};
