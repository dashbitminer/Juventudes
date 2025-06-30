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
        Schema::table('sesiones', function (Blueprint $table) {
            $table->foreignId('actividad_id')
                ->after('cohorte_pais_proyecto_id')
                ->nullable()
                ->constrained('actividades', 'id', 'fk_actividad_sesiones')
                ->onDelete('cascade');

            $table->foreignId('subactividad_id')
                ->after('actividad_id')
                ->nullable()
                ->constrained('subactividades', 'id', 'fk_subactividades_sesiones')
                ->onDelete('cascade');

            $table->foreignId('modulo_id')
                ->after('subactividad_id')
                ->nullable()
                ->constrained('modulos', 'id', 'fk_modulos_sesiones')
                ->onDelete('cascade');

            $table->foreignId('submodulo_id')
                ->after('modulo_id')
                ->nullable()
                ->constrained('submodulos', 'id', 'fk_submodulos_sesiones')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sesiones', function (Blueprint $table) {
            //
        });
    }
};
