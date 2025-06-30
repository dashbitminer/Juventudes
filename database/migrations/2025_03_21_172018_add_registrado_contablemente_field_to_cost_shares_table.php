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
        Schema::table('cost_shares', function (Blueprint $table) {
            $table->boolean('registrado_contablemente')->nullable()->default(null)->after('nombre_persona_registra');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cost_shares', function (Blueprint $table) {
            $table->dropColumn('registrado_contablemente');
        });
    }
};
