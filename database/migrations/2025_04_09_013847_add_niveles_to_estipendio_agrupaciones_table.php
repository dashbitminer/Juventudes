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
        Schema::table('estipendio_agrupaciones', function (Blueprint $table) {
            $table->json('actividades')->nullable()->after('color');
            $table->json('subactividades')->nullable()->after('actividades');
            $table->json('modulos')->nullable()->after('subactividades');
            $table->json('submodulos')->nullable()->after('modulos');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('estipendio_agrupaciones', function (Blueprint $table) {
            //
        });
    }
};
