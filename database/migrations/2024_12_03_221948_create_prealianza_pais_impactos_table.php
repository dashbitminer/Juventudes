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
        Schema::create('prea_pais_impacto_potenciales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pre_alianza_id')->constrained('pre_alianzas');
            $table->foreignId('pais_impacto_potencial_id')->constrained('pais_impacto_potenciales')
            ->name('fk_prea_pais_impacto_potencial');
            $table->timestamps();
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prea_pais_impacto_potenciales');
    }
};
