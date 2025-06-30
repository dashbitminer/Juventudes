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
        Schema::create('direcciones_guatemala', function (Blueprint $table) {
            $table->id();
            $table->foreignId('participante_id')->constrained('participantes');
            $table->foreignId('ciudad_id')->constrained('ciudades');
            $table->text('direccion')->nullable();
            $table->string('casa')->nullable();
            $table->string('apartamento')->nullable();
            $table->string('zona')->nullable();
            $table->string('colonia')->nullable();
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
        Schema::dropIfExists('direcciones_guatemala');
    }
};
