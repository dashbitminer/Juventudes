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
            $table->foreignId('cohorte_participante_proyecto_id')
                ->after('id')
                ->nullable()
                ->constrained('cohorte_participante_proyecto', 'id', 'fk_cohorte_participante_proyecto_ficha_emprendimientos');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ficha_emprendimientos', function (Blueprint $table) {
            $table->dropForeign('cohorte_participante_proyecto_id');
        });
    }
};
