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
        Schema::table('ficha_emprendimientos', function (Blueprint $table) {
            $table->text('medio_verificacion_file')
                ->after('medio_verificacion_otros')
                ->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ficha_emprendimientos', function (Blueprint $table) {
            $table->dropColumn('medio_verificacion_file');
        });
    }
};
