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
        Schema::table('sesion_titulos', function (Blueprint $table) {
            $table->foreignId('cohorte_pais_proyecto_perfil_id')
                ->after('cohorte_pais_proyecto_id')
                ->nullable()
                ->constrained('cohorte_pais_proyecto_perfil', 'id', 'fk_cohorte_pais_proyecto_perfil_sesion_titulos');

            $table->foreignId('actividad_id')
                ->after('cohorte_pais_proyecto_perfil_id')
                ->nullable()
                ->constrained('actividades', 'id', 'fk_actividad_sesion_titulos');

            $table->foreignId('subactividad_id')
                ->after('actividad_id')
                ->nullable()
                ->constrained('subactividades', 'id', 'fk_subactividades_sesion_titulos');

            $table->foreignId('modulo_id')
                ->after('subactividad_id')
                ->nullable()
                ->constrained('modulos', 'id', 'fk_modulos_sesion_titulos');

            $table->foreignId('submodulo_id')
                ->after('modulo_id')
                ->nullable()
                ->constrained('submodulos', 'id', 'fk_submodulos_sesion_titulos');
        });

        Schema::table('sesion_tipos', function (Blueprint $table) {
            $table->foreignId('cohorte_pais_proyecto_perfil_id')
                ->after('cohorte_pais_proyecto_id')
                ->nullable()
                ->constrained('cohorte_pais_proyecto_perfil', 'id', 'fk_cohorte_pais_proyecto_perfil_sesion_tipos');

            $table->foreignId('actividad_id')
                ->after('cohorte_pais_proyecto_perfil_id')
                ->nullable()
                ->constrained('actividades', 'id', 'fk_actividad_sesion_tipos');

            $table->foreignId('subactividad_id')
                ->after('actividad_id')
                ->nullable()
                ->constrained('subactividades', 'id', 'fk_subactividades_sesion_tipos');

            $table->foreignId('modulo_id')
                ->after('subactividad_id')
                ->nullable()
                ->constrained('modulos', 'id', 'fk_modulos_sesion_tipos');

            $table->foreignId('submodulo_id')
                ->after('modulo_id')
                ->nullable()
                ->constrained('submodulos', 'id', 'fk_submodulos_sesion_tipos');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sesion_titulos', function (Blueprint $table) {
            //
        });
    }
};
