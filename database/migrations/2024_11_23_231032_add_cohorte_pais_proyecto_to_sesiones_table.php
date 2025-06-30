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
            $table->foreignId('cohorte_pais_proyecto_id')
                ->after('id')
                ->nullable()
                ->constrained('cohorte_pais_proyecto', 'id', 'fk_cohorte_pais_proyecto_sesiones');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sesiones', function (Blueprint $table) {
            $table->dropForeign('cohorte_pais_proyecto_id');
        });
    }
};
