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
        Schema::create('sesion_participante_time_trackings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sesion_participante_id')
                ->constrained('sesion_participantes', 'id', 'fk_sesion_participantes_sesion_participante_id');
            $table->date('fecha');
            $table->integer('hora')->default(0)->comment('Hora de la sesion');
            $table->integer('minuto')->default(0)->comment('Minutos de la sesion');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sesion_participante_time_trackings');
    }
};
