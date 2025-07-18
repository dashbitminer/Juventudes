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
        Schema::table('estipendio_participantes', function (Blueprint $table) {
            $table->decimal('monto_estipendio', 10, 2)
                ->nullable()
                ->after('porcentaje_estipendio')
                ->comment('Monto del Estipendio (estipendios.monto * porcentaje_estipendio)');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('estipendio_participantes', function (Blueprint $table) {
            $table->dropColumn('monto_estipendio');
        });
    }
};
