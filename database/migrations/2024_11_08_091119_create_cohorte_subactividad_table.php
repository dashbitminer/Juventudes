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
        Schema::create('cohorte_subactividad', function (Blueprint $table) {
            $table->id();
           // $table->foreignId('cohorte_proyecto_socio_id')->constrained('cohorte_proyecto_socio')->onDelete('cascade');
            $table->foreignId('cohorte_pais_proyecto_id')->constrained('cohorte_pais_proyecto')->onDelete('cascade');
            $table->foreignId('subactividad_id')->constrained('subactividades')->onDelete('cascade');
            $table->datetime('active_at')->nullable();
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
        Schema::dropIfExists('cohorte_subactividad');
    }
};
