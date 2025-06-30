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
        Schema::table('cohorte_participante_proyecto', function (Blueprint $table) {
            $table->foreignId('cohorte_pais_proyecto_perfil_id')
                ->nullable( )
                ->constrained('cohorte_pais_proyecto_perfil', 'id', 'fk_perfil_participante_cohorte')
                ->after('participante_id');

            $table->string('numero_cuenta', 50)->nullable()->after('cohorte_pais_proyecto_perfil_id');

            $table->boolean('participacion_voluntaria')->default(false)->after('numero_cuenta');
            $table->boolean('recoleccion_uso_glasswing')->default(false)->after('numero_cuenta');
            $table->boolean('compartir_para_investigaciones')->default(false)->after('numero_cuenta');
            $table->boolean('compartir_para_bancarizacion')->default(false)->after('numero_cuenta');
            $table->boolean('compartir_por_gobierno')->default(false)->after('numero_cuenta');
            $table->boolean('voz_e_imagen')->default(false)->after('numero_cuenta');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cohorte_participante_proyecto', function (Blueprint $table) {
            //
        });
    }
};
