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
        Schema::create('servicio_comunitarios', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->foreignId('socio_implementador_id')->constrained('socios_implementadores');
            $table->string('personal_socio_seguimiento')->nullable();
            $table->string('nombre')->nullable();
            $table->integer('total_jovenes')->nullable();
            $table->integer('total_adultos_jovenes')->nullable();
            $table->foreignId('pais_id')->constrained('paises', 'id');
            $table->unsignedBigInteger('ciudad_id')->nullable();
            $table->unsignedBigInteger('departamento_id')->nullable();
            $table->string('comunidad')->nullable();
            $table->text('descripcion')->nullable()->default(null);
            $table->text('objetivos')->nullable()->default(null);
            $table->text('riesgos_potenciales')->nullable()->default(null);
            $table->text('describir_calificaciones')->nullable()->default(null);
            $table->text('capacitacion')->nullable()->default(null);
            
            $table->foreignId('pais_recurso_previsto_id')
                ->nullable()
                ->constrained('pais_recurso_previstos', 'id', 'fk_referencias_pais_recurso_previsto_id');

            $table->foreignId('pais_usaid_recurso_previsto_id')
                ->nullable()
                ->constrained('pais_usaid_recurso_previstos', 'id', 'fk_referencias_pais_usaid_recurso_previsto_id');

            $table->foreignId('pais_cs_recurso_previsto_id')
                ->nullable()
                ->constrained('pais_cs_recurso_previstos', 'id', 'fk_referencias_pais_cs_recurso_previsto_id');

            $table->foreignId('pais_lev_recurso_previsto_id')
                ->nullable()
                ->constrained('pais_lev_recurso_previstos', 'id', 'fk_referencias_pais_lev_recurso_previsto_id');

            $table->string('recursos_previstos_especifique')->nullable();

            $table->decimal('monto_local', 12, 2)->nullable()->comment('Monto local de cada pais');
            $table->decimal('monto_dolar', 12, 2)->nullable()->comment('Monto local de dolares');
            
            $table->date("fecha_entrega")->nullable();
            $table->text('proyeccion_pedagogica')->nullable()->default(null);
            $table->text('retroalimentacion')->nullable()->default(null);

            $table->foreignId('pais_pcj_sostenibilidad_id')
                ->nullable()
                ->constrained('pais_pcj_sostenibilidades', 'id', 'fk_referencias_pais_pcj_sostenibilidad_id');
            
            $table->foreignId('pais_pcj_alcance_id')
                ->nullable()
                ->constrained('pais_pcj_alcances', 'id', 'fk_referencias_pais_pcj_alcance_id');
            
            $table->foreignId('pais_pcj_fortalece_area_id')
                ->nullable()
                ->constrained('pais_pcj_fortalece_areas', 'id', 'fk_referencias_pais_pcj_fortalece_area_id');

            $table->tinyInteger('tipo_poblacion_beneficiada')->nullable();

            $table->foreignId('pais_poblacion_beneficiada_id')
                ->nullable()
                ->constrained('pais_poblacion_beneficiadas', 'id', 'fk_referencias_pais_poblacion_beneficiada_id');
            $table->integer('total_poblacion')->nullable();    

            $table->tinyInteger('comunidad_colabora')->nullable()->comment('1: Si, 0: No');
            $table->tinyInteger('gobierno_colabora')->nullable()->comment('1: Si, 0: No');
            $table->tinyInteger('empresa_privada_colabora')->nullable()->comment('1: Si, 0: No');
            $table->tinyInteger('organizaciones_juveniles_colabora')->nullable()->comment('1: Si, 0: No');
            $table->tinyInteger('ong_colabora')->nullable()->comment('1: Si, 0: No');
            $table->tinyInteger('posee_carta_entendimiento')->nullable()->comment('1: Si, 0: No');
            $table->tinyInteger('estado')->nullable();

            $table->text('observaciones')->nullable()->default(null);

            $table->text('apoyos_requeridos')->nullable()->default(null);
            
            $table->integer('progreso')->nullable();

            $table->string('nombre_reporta')->nullable();
            $table->string('cargo_reporta')->nullable();
            $table->date("fecha_elaboracion")->nullable();

            $table->string('nombre_valida')->nullable();
            $table->string('cargo_valida')->nullable();
            $table->date("fecha_valida")->nullable();

            $table->datetime('active_at')->nullable();
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
        Schema::dropIfExists('servicio_comunitarios');
    }
};
