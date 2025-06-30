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
        Schema::create('estado_participante', function (Blueprint $table) {
            $table->id();
            $table->foreignId('grupo_participante_id')->constrained('grupo_participante')->comment('Participante en el grupo');
            $table->foreignId('estado_id')->constrained()->comment('Estado del participante');
            $table->foreignId('razon_id')->nullable()->constrained('razones')->comment('Razón del estado del participante');
            $table->date('fecha')->nullable()->comment('Fecha del estado');
            $table->text('comentario')->nullable();
            $table->datetime('active_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->integer('created_by')->nullable()->default(null);
            $table->integer('updated_by')->nullable()->default(null);
            $table->integer('deleted_by')->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estado_participantes');
    }
};
