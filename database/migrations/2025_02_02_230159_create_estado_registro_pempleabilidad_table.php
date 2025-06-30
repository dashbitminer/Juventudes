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
        Schema::create('estado_registro_pempleabilidad', function (Blueprint $table) {
            $table->id();
            $table->foreignId('practica_empleabilidad_id')->constrained('practica_empleabilidad');
            $table->foreignId('estado_registro_id')->constrained('estado_registros');
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
        Schema::dropIfExists('estado_registro_pempleabilidad');
    }
};
