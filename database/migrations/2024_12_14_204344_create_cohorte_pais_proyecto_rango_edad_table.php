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
        Schema::create('cohorte_pais_proyecto_rango_edad', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cohorte_pais_proyecto_id')->constrained('cohorte_pais_proyecto', 'id', 'fk_cohorte_pais_proyecto_rango_edad');
            $table->smallInteger('edad_inicio');
            $table->smallInteger('edad_fin');
            $table->date('fecha_comparacion')->nullable();
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
        Schema::dropIfExists('cohorte_pais_proyecto_rango_edad');
    }
};
