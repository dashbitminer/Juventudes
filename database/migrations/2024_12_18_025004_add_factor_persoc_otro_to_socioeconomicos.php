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
        Schema::table('socioeconomicos', function (Blueprint $table) {
            $table->text('factor_persoc_otro')->nullable()->after('informacion_relevante');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('socioeconomicos', function (Blueprint $table) {
            //
        });
    }
};
