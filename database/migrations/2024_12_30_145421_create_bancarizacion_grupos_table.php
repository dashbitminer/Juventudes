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
        Schema::create('bancarizacion_grupos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->foreignId('cohorte_pais_proyecto_id')->constrained('cohorte_pais_proyecto', 'id', 'fk_bancarizacion_cohorte_pais_proyecto');
            $table->string('descripcion')->nullable()->default(null);
            $table->decimal('monto', 10, 2);
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
        Schema::dropIfExists('bancarizacion_grupos');
    }
};
