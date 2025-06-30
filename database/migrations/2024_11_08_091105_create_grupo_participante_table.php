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
        Schema::create('grupo_participante', function (Blueprint $table) {
            $table->id();
            $table->foreignId('grupo_id')->constrained()->comment('Grupo al que pertenece el participante');
            $table->foreignId('user_id')->comment('Usuario Gestor que creó el grupo en una cohorte');
            $table->foreignId('cohorte_participante_proyecto_id')->constrained('cohorte_participante_proyecto')->comment('Registro del participante en cohorte-pais-proyecto');
            // $table->foreignId('participante_id')->constrained()->comment('Participante que pertenece al grupo');
            // $table->foreignId('cohorte_id')->comment('Cohorte a la que pertenece el grupo');
            // $table->foreignId('pais_proyecto_id')->nullable()->comment('Pais del proyecto');
            $table->datetime('active_at')->nullable();
            $table->text('comentario')->nullable();
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
        Schema::dropIfExists('grupo_participante');
    }
};
