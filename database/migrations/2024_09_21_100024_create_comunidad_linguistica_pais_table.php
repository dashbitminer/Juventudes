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
        Schema::create('comunidad_linguistica_pais', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pais_id')->constrained('paises', 'id')->comment('País Id');
            $table->foreignId('comunidad_linguistica_id')->constrained('comunidad_linguisticas', 'id')->comment('Comunidad Linguistica Id');
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
        Schema::dropIfExists('comunidad_linguistica_pais');
    }
};
