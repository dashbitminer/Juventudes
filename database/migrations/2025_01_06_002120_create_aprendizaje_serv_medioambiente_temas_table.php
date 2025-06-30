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
        Schema::create('as_medioambiente_temas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('aprendizaje_servicio_id')->constrained('aprendizaje_servicios');
            $table->foreignId('pais_medioambiente_tema_id')->constrained('pais_medioambiente_temas')
            ->name('fk_as_pais_medioambiente_tema_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('as_medioambiente_temas');
    }
};
