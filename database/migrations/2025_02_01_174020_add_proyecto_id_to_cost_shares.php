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
            $table->foreignId('proyecto_id')
                ->nullable()
                ->after('pais_id')
                ->constrained('proyectos', 'id')
                ->comment('Proyecto Id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cost_shares', function (Blueprint $table) {
            //
        });
    }
};
