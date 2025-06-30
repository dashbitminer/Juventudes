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
        Schema::create('emprendimiento_medio_verificaciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ficha_emprendimiento_id')
                ->nullable()
                ->constrained('ficha_emprendimientos', 'id', 'fk_ficha_emprendimientos_ficha_emprendimiento_id');
            $table->foreignId('medio_verificacion_id')
                ->nullable()
                ->constrained('medio_verificacion_emprendimientos', 'id', 'fk_medio_verificacion_emprendimientos_medio_verificacion_id');
            $table->text('comentario')->nullable();
            $table->timestamp('active_at')->nullable();
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
        Schema::dropIfExists('emprendimiento_medio_verificaciones');
    }
};
