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
        Schema::create('pais_motivo_cambio_organizacion', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pais_id')->constrained('paises', 'id', 'fk_pais_motivo_cambio')->onDelete('cascade');
            $table->foreignId('motivo_cambio_organizacion_id')->constrained('motivos_cambio_organizacion', 'id', 'fk_motivo_cambio_pais')->onDelete('cascade');
            $table->text('otro_motivo')->nullable();
            $table->timestamp('active_at')->nullable()->default(null);
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
        Schema::dropIfExists('pais_motivo_cambio_organizacion');
    }
};
