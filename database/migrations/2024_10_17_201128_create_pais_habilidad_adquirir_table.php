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
        Schema::create('pais_habilidad_adquirir', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pais_id')
                ->constrained('paises', 'id', 'fk_pais_habilidad_adquirir')
                ->onDelete('cascade');
            $table->foreignId('habilidad_adquirir_id')
                ->constrained('habilidades_adquirir', 'id', 'fk_habilidad_adquirir_pais')
                ->onDelete('cascade');
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
        Schema::dropIfExists('pais_habilidad_adquirir');
    }
};
