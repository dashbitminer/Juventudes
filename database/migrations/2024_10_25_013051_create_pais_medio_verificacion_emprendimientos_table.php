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
        Schema::create('pais_medio_verificacion_emprendimientos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('medio_verificacion_emprendimiento_id')
                ->constrained('medio_verificacion_emprendimientos', 'id', 'fk_medio_verificacion_emprendimientos_id');
            $table->foreignId('pais_id')->constrained('paises', 'id')->comment('Pais Id');
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
        Schema::dropIfExists('pais_medio_verificacion_emprendimientos');
    }
};
