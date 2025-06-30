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
        Schema::create('cohorte_proyecto_socio', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pais_proyecto_socio_id')->constrained('pais_proyecto_socios', 'id', 'fk_pais_proyecto_socio_cohorte')->comment('Pais proyecto socio');
            $table->foreignId('cohorte_id')->constrained('cohortes')->comment('Cohorte');
            $table->text('comentario')->nullable();
            $table->boolean('titulo_abierto')->default(false);
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
        Schema::dropIfExists('cohorte_proyecto_socio');
    }
};
