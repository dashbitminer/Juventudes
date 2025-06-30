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
        Schema::create('pais_proyecto_socio_resultados', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pais_proyecto_socio_id')->constrained()->comment('País Proyecto Socio Id');
            $table->foreignId('resultado_id')->constrained()->comment('Resultado Id');
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
        Schema::dropIfExists('pais_proyecto_socio_resultados');
    }
};
