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
        Schema::create('pais_verificacion_ficha_formacion', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pais_medio_verificacion_formacion_id')
                ->constrained('pais_medio_verificacion_formaciones', 'id', 'fk_pais_verficacion_ficha_formacion')
                ->onDelete('cascade');
            $table->foreignId('ficha_formacion_id')
                ->constrained('ficha_formaciones', 'id', 'fk_ficha_formacion_pais_verificacion')
                ->onDelete('cascade');
            $table->text('medio_verificacion_file')->nullable();
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
        Schema::dropIfExists('pais_verificacion_ficha_formacion');
    }
};
