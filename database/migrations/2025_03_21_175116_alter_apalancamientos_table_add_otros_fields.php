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
        Schema::table('apalancamientos', function (Blueprint $table) {
            $table->text('otros_recursos_sector')->nullable()->default(null)->after('pais_origen_recurso_id');
            $table->text('otros_fuente_recursos_sector')->nullable()->default(null)->after('pais_fuente_recurso_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('apalancamientos', function (Blueprint $table) {
            $table->dropColumn('otros_recursos_sector');
            $table->dropColumn('otros_fuente_recursos_sector');
        });
    }
};
