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
        Schema::table('ficha_emprendimientos', function (Blueprint $table) {
            $table->foreignId('ingresos_promedio_id')
                ->after('monto_dolar')
                ->nullable()
                ->constrained('ingresos_promedios', 'id', 'fk_ingresos_promedios_ficha_emprendimiento');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ficha_emprendimientos', function (Blueprint $table) {
            $table->dropForeign('fk_ingresos_promedios_ficha_emprendimiento');
        });
    }
};
