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
        Schema::table('cohorte_actividades', function (Blueprint $table) {
            $table->foreignId('cohorte_pais_proyecto_perfil_id')
                ->after('cohorte_pais_proyecto_id')
                ->nullable()
                ->constrained('cohorte_pais_proyecto_perfil', 'id', 'fk_cohorte_actividades_cohorte_pais_proyecto_perfil');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cohorte_actividades', function (Blueprint $table) {
            //
        });
    }
};
