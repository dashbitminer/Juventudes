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
        Schema::create('grupo_perteneciente_pais', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pais_id')->constrained('paises', 'id');
            $table->foreignId('grupo_perteneciente_id')->constrained('grupo_pertenecientes', 'id', 'fk_grupo_pertenecientes_id');
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
        Schema::dropIfExists('grupo_perteneciente_pais');
    }
};
