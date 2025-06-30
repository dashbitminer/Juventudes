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
        Schema::create('sc_poblacion_indirectas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('servicio_comunitario_id')->constrained('servicio_comunitarios');
            $table->foreignId('pais_poblacion_beneficiada_id')->constrained('pais_poblacion_beneficiadas')
            ->name('fk_sc_poblacion_ben_indirecta');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sc_poblacion_indirecta');
    }
};
