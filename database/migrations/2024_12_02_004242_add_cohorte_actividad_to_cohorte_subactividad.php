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
            $table->dropForeign(['cohorte_pais_proyecto_id']);
            $table->dropColumn('cohorte_pais_proyecto_id');

            $table->foreignId('cohorte_actividad_id')
                ->after('id')
                ->nullable()
                ->constrained('cohorte_actividades', 'id', 'fk_cohorte_subactividad_cohorte_actividades')
                ->onDelete('cascade');
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
