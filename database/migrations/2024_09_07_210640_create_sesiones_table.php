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
        Schema::create('sesiones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('grupo_id')->constrained()->comment('Grupo al que pertenece el participante');
            $table->date('fecha');
            $table->date('fecha_fin')->nullable()->default(null);
            $table->foreignId('titulo_id')->nullable()->default(null)->constrained('titulos')->comment('Titulo cerrado');
            $table->string('titulo')->nullable()->default(null)->comment('Titulo abierto');
            $table->text('comentario')->nullable();
            $table->decimal('duracion', 8, 2)->default(0);
            $table->integer('modelable_id');
            $table->string('modelable_type');
            $table->timestamp('active_at')->nullable();
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
        Schema::dropIfExists('sesions');
    }
};
