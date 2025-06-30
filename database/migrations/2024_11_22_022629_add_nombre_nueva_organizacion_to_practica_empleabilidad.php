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
        // Schema::table('practica_empleabilidad', function (Blueprint $table) {
        //     $table->string('nombre_nueva_organizacion')
        //         ->after('cambiar_organizacion')
        //         ->nullable();
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Schema::table('practica_empleabilidad', function (Blueprint $table) {
        //     $table->dropColumn('nombre_nueva_organizacion');
        // });
    }
};
