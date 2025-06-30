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
        Schema::create('categoria_razones', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->comment('Nombre del criterio');
            $table->text('comentario')->nullable();
            $table->string('slug')->unique();
            $table->tinyInteger('tipo')->default(1)->comment('1: Razón de Desertado, 2: Razón de Pausa, 3: Razón de Reingreso');
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
        Schema::dropIfExists('categoria_razones');
    }
};
