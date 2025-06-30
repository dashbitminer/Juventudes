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
        Schema::create('objetivo_asistencia_alianza_pais', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pais_id')->constrained('paises')->comment('País Id');
            $table->foreignId('objetivo_asistencia_alianza_id')
                    ->constrained('objetivo_asistencia_alianzas','id', 'fk_objetivo_alianzas')
                    ->comment('Objetivo Alianza Id');
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
        Schema::dropIfExists('objetivo_asistencia_alianza_pais');
    }
};
