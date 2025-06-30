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
        Schema::table('aprendizaje_servicios', function (Blueprint $table) {

            $table->foreignId('cohorte_participante_proyecto_id')
                ->after('id')
                ->nullable()
                ->constrained('cohorte_participante_proyecto', 'id', 'fk_cohorte_participante_proyecto_aprendizaje_servicios');

            $table->boolean('cambiar_organizacion')->default(false)->after('cohorte_participante_proyecto_id');

            $table->foreignId('pais_motivo_cambio_organizacion_id')->nullable()
                    ->constrained('pais_motivo_cambio_organizacion', 'id', 'fk_pais_motivo_cambio_aprendizaje')
                    ->after('cambiar_organizacion');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('aprendizaje_servicios', function (Blueprint $table) {
            $table->dropForeign('cohorte_participante_proyecto_id');
        });
    }
};
