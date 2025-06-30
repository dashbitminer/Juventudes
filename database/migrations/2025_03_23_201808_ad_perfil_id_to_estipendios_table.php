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
        Schema::table('estipendios', function (Blueprint $table) {
            $table->foreignId('cohorte_pais_proyecto_perfil_id')->after('perfil_participante_id')->nullable()->default(null)
            ->constrained('cohorte_pais_proyecto_perfil', 'id', 'fk_estipendio_cohorte_pais_proyecto_perfil');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('estipendios', function (Blueprint $table) {
            $table->dropForeign('fk_estipendio_cohorte_pais_proyecto_perfil');
            $table->dropColumn('cohorte_pais_proyecto_perfil_id');
        });
    }
};
