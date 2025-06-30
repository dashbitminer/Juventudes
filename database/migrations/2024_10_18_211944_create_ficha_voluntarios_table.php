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
        Schema::create('ficha_voluntarios', function (Blueprint $table) {

            $table->id();

            /* Se creo una migracion para agregar cohorte_participante_proyecto_id
               add_cohorte_participante_proyecto_to_ficha_voluntarios */

            // $table->foreignId('cohorte_participante_proyecto_id')
            //     ->nullable()
            //     ->constrained('cohorte_participante_proyecto', 'id', 'fk_voluntario_cohorte_participante_proyecto');

            // $table->foreignId('pais_id')
            //     ->constrained('paises', 'id', 'fk_voluntario_pais');

            // $table->foreignId('cohorte_id')
            //     ->constrained('cohortes', 'id', 'fk_voluntario_cohorte');

            // $table->foreignId('participante_id')
            //     ->constrained('participantes', 'id', 'fk_voluntario_participante');

            $table->foreignId('pais_medio_vida_id')
                ->nullable()
                ->constrained('pais_medio_vidas', 'id', 'fk_voluntario_medio_vida');

            $table->foreignId('directorio_id')
                ->nullable()
                ->constrained('directorios', 'id', 'fk_voluntario_directorio');

            $table->date('fecha_inicio_voluntariado')->nullable()->default(null);
            $table->smallInteger('promedio_horas')->nullable()->default(null);

            $table->foreignId('pais_area_intervencion_id')
                ->nullable()
                ->constrained('pais_area_intervenciones', 'id', 'fk_voluntario_pais_areas_intervencion');

            $table->foreignId('pais_vinculado_debido_id')
                ->nullable()
                ->constrained('pais_vinculado_debido', 'id', 'fk_vinculado_pais_voluntario_ficha');

            $table->foreignId('pais_medio_verificacion_voluntario_id')
                ->nullable()
                ->constrained('pais_medio_verificacion_voluntario', 'id', 'fk_fvoluntario_verificacion_pais');

            $table->text('vinculado_otro')->nullable();
            $table->text('servicio_otro')->nullable();

            $table->text('medio_verificacion_file')->nullable();

            $table->text('informacion_adicional')->nullable();

            $table->timestamp('active_at')->nullable()->default(null);
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
        Schema::dropIfExists('ficha_voluntarios');
    }
};
