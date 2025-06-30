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
        Schema::create('grupo_etnico_pais', function (Blueprint $table) {
            $table->id();
            $table->foreignId('grupo_etnico_id')->constrained('grupo_etnicos', 'id', 'fk_grupo_etnico_pais_grupo_etnico');
            $table->foreignId('pais_id')->constrained('paises', 'id', 'fk_grupo_etnico_pais_pais');
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
        Schema::dropIfExists('grupo_etnico_pais');
    }
};
