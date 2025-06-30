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
        Schema::create('validador_registradores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('validador_id')->constrained('users');
            $table->foreignId('registrador_id')->constrained('users');
            $table->foreignId('pais_proyecto_id')->constrained('pais_proyecto');
            $table->datetime('active_at')->nullable();
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
        Schema::dropIfExists('validador_registradores');
    }
};
