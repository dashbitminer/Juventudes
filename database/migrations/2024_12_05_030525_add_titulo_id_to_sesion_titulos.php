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
            $table->dropForeign(['pais_id']);
            $table->dropColumn('pais_id');

            $table->foreignId('cohorte_pais_proyecto_id')
                ->after('titleable_type')
                ->nullable()
                ->constrained('cohorte_pais_proyecto', 'id', 'fk_sesion_titulos_cohorte_pais_proyecto')
                ->onDelete('cascade');

            $table->foreignId('titulo_id')
                ->after('titulo_abierto')
                ->nullable()
                ->constrained('titulos', 'id', 'fk_sesion_titulos_titulos')
                ->onDelete('cascade');
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
