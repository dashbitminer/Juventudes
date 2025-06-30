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
            $table->foreignId('pais_organizacion_alianza_id')
                ->nullable()
                ->after('socio_implementador_id')
                ->constrained('pais_organizacion_alianza') 
                ->onDelete('cascade') 
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cost_shares', function (Blueprint $table) {
            $table->dropForeign(['pais_organizacion_alianza_id']);
            $table->dropColumn('pais_organizacion_alianza_id');
        });
    }
};
