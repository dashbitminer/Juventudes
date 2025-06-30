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
        Schema::create('modulo_subactividad_submodulo', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cohorte_subactividad_modulo_id')->constrained('cohorte_subactividad_modulo', 'id', 'fk_modulos_submodulos_cohorte')->onDelete('cascade');
            $table->foreignId('submodulo_id')->constrained('submodulos')->onDelete('cascade');
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
        Schema::dropIfExists('modulo_submodulo');
    }
};
