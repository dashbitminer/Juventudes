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
        Schema::table('pre_alianzas', function (Blueprint $table) {
            $table->foreignId('pais_cobertura_geografica_id')
                ->after('active_at')
                ->constrained('pais_cobertura_geografica', 'id', 'fk_pais_cobertura_geo')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pre_alianzas', function (Blueprint $table) {
            $table->dropForeign(['pais_cobertura_geografica_id']);
            $table->dropColumn('pais_cobertura_geografica_id');
        });
    }
};
