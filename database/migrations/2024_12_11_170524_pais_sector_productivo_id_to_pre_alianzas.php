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
            $table->foreignId('pais_sector_productivo_id')
            ->nullable()
            ->after('pertenece_cpa')
            ->constrained('pais_sector_productivos');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pre_alianzas', function (Blueprint $table) {
            //
        });
    }
};
