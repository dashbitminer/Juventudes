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
        Schema::table('cohorte_subactividad', function (Blueprint $table) {
            $table->foreignId('cohorte_pais_proyecto_id')
                ->after('id')
                ->nullable()
                ->constrained('cohorte_pais_proyecto');

            $table->foreignId('cohorte_pais_proyecto_perfil_id')
                ->after('cohorte_pais_proyecto_id')
                ->nullable()
                ->constrained('cohorte_pais_proyecto_perfil', 'id', 'fk_cohorte_subactividad_perfil');
        });

        Schema::table('cohorte_subactividad_modulo', function (Blueprint $table) {
            $table->foreignId('cohorte_pais_proyecto_id')
                ->after('id')
                ->nullable()
                ->constrained('cohorte_pais_proyecto');

            $table->foreignId('cohorte_pais_proyecto_perfil_id')
                ->after('cohorte_pais_proyecto_id')
                ->nullable()
                ->constrained('cohorte_pais_proyecto_perfil', 'id', 'fk_cohorte_subactividad_modulo_perfil');
        });

        Schema::table('modulo_subactividad_submodulo', function (Blueprint $table) {
            $table->foreignId('cohorte_pais_proyecto_id')
                ->after('id')
                ->nullable()
                ->constrained('cohorte_pais_proyecto');

            $table->foreignId('cohorte_pais_proyecto_perfil_id')
                ->after('cohorte_pais_proyecto_id')
                ->nullable()
                ->constrained('cohorte_pais_proyecto_perfil', 'id', 'fk_modulo_subactividad_submodulo_perfil');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cohorte_subactividad', function (Blueprint $table) {
            //
        });
    }
};
