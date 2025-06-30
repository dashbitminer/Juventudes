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
            $table->decimal('monto_especie', 12, 2)->nullable()
            ->after('monto_esperado');
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
