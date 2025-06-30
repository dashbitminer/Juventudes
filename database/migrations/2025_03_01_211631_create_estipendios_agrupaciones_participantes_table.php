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
        Schema::create('estipendios_agrupaciones_participantes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('estipendio_agrupacion_id')->constrained('estipendio_agrupaciones', 'id', 'fk_estipendio_agrupacion_participante');
            $table->foreignId('participante_id')->constrained('participantes', 'id', 'fk_participante_estipendio_agrupacion');

            $table->decimal('suma', 10, 2);
            $table->decimal('porcentaje', 10, 2);
            $table->text('alerta')->nullable()->default(null);

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
        Schema::dropIfExists('estipendios_agrupaciones_participantes');
    }
};
