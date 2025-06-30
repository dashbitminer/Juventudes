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
        Schema::create('ficha_formaciones', function (Blueprint $table) {
            $table->id();

            // $table->foreignId('pais_id')
            //     ->constrained('paises', 'id', 'fk_f_formacion_pais');

            // $table->foreignId('cohorte_id')
            //     ->constrained('cohortes', 'id', 'fk_f_formacion_cohorte');

            // $table->foreignId('proyecto_id')
            //     ->constrained('proyectos', 'id', 'fk_f_formacion_proyecto');

            // $table->foreignId('participante_id')
            //     ->constrained('participantes', 'id', 'fk_f_formacion_participante');

            $table->foreignId('pais_medio_vida_id')
                ->nullable()
                ->constrained('pais_medio_vidas', 'id', 'fk_f_formacion_medio_vida');

            $table->foreignId('directorio_id')
                ->nullable()
                ->constrained('directorios', 'id', 'fk_f_formacion_directorio');

            $table->foreignId('pais_tipo_estudio_id')
                ->nullable()
                ->constrained('pais_tipo_estudio', 'id', 'fk_f_formacion_tipo_estudio');

            $table->text('otro_tipo_estudio')->nullable();

            $table->smallInteger('total_horas_duracion')->nullable()->default(null);

            $table->foreignId('pais_area_formacion_id')
                ->nullable()
                ->constrained('pais_area_formaciones', 'id', 'fk_f_formacion_area_formacion');

            $table->foreignId('pais_nivel_educativo_formacion_id')
                ->nullable()
                ->constrained('pais_nivel_educativo_formaciones', 'id', 'fk_f_formacion_nivel_educativo');

            $table->text('nombre_curso')->nullable();

            $table->text('informacion_adicional')->nullable();

            $table->smallInteger('tipo_modalidad')->nullable()->default(null)->comment('1: virtual, 2: presencial, 3: Virtual y presencial');

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
        Schema::dropIfExists('ficha_formacions');
    }
};
