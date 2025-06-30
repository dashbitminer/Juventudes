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
        Schema::create('cs_pais_costshare_resultados', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cost_share_id')->constrained('cost_shares');
            $table->foreignId('pais_costshare_resultado_id')->constrained('pais_costshare_resultados');
            $table->integer('porcentaje');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cs_pais_costshare_resultados');
    }
};
