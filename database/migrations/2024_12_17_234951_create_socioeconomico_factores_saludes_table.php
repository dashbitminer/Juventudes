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
        Schema::create('socioeconomico_factores_saludes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('socioeconomico_id')->constrained('socioeconomicos');
            $table->foreignId('pais_factores_salud_id')->constrained('pais_factores_saludes')
            ->name('fk_socioeconomico_factor_salud');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('socioeconomico_factores_saludes');
    }
};
