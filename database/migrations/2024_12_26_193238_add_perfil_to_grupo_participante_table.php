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
        Schema::table('grupo_participante', function (Blueprint $table) {
            $table->foreignId('cohorte_pais_proyecto_perfil_id')
                ->after('cohorte_participante_proyecto_id')
                ->nullable()
                ->constrained('cohorte_pais_proyecto_perfil', 'id', 'fk_grupo_participante_perfil_participante');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('grupo_participante', function (Blueprint $table) {
            //
        });
    }
};
