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
            $table->smallInteger('tipo_contacto')
                ->nullable()
                ->after('cargo_contacto')
                ->comment('1: Lobby, 2: Primario, 3: Secundario, 4: No definido');
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
