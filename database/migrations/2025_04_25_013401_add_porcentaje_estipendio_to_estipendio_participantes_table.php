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
            $table->decimal('porcentaje_estipendio', 5, 2)->nullable()->after('porcentaje');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('estipendio_participantes', function (Blueprint $table) {
            $table->dropColumn('porcentaje_estipendio');
        });
    }
};
