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
        Schema::create('pais_proyecto_socios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pais_proyecto_id')->constrained('pais_proyecto');
            $table->foreignId('socio_implementador_id')->constrained('socios_implementadores');
            $table->foreignId('modalidad_id')->constrained('modalidades');
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
        Schema::dropIfExists('pais_proyecto_socios');
    }
};
