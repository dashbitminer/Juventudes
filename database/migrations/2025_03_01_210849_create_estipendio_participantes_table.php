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
        Schema::create('estipendio_participantes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('estipendio_id')->constrained('estipendios', 'id', 'fk_estipendio_participantes');
            $table->foreignId('participante_id')->constrained('participantes', 'id', 'fk_participante_estipendio');
            $table->decimal('porcentaje', 10, 2);
            $table->text('observacion')->nullable()->default(null);
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
        Schema::dropIfExists('estipendio_participantes');
    }
};
