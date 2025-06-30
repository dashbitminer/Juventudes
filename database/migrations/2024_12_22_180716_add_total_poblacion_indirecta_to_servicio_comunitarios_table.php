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
        Schema::table('servicio_comunitarios', function (Blueprint $table) {
            $table->integer('total_poblacion_indirecta')->nullable()->after('total_poblacion'); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('servicio_comunitarios', function (Blueprint $table) {
            //
        });
    }
};
