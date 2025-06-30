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
        Schema::table('servicio_comunitarios', function (Blueprint $table) {
            $table->foreignId('cohorte_pais_proyecto_id')
                ->nullable()
                ->after('socio_implementador_id')
                ->constrained('cohorte_pais_proyecto')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('servicio_comunitarios', function (Blueprint $table) {
            $table->dropForeign(['cohorte_pais_proyecto_id']);
            $table->dropColumn('cohorte_pais_proyecto_id');
        });
    }
};
