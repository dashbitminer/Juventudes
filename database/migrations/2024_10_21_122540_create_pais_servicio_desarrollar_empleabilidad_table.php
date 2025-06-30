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
        Schema::create('pais_servicio_desarrollar_empleabilidad', function (Blueprint $table) {
            $table->id();

            $table->foreignId('pais_servicio_desarrollar_id')
                ->constrained('pais_servicio_desarrollar', 'id', 'fk_pais_servicio_desarrollar_empleabilidad')
                ->onDelete('cascade');

            $table->foreignId('practica_empleo_id')->constrained('practica_empleabilidad', 'id', 'fk_pais_servicio_empleo')
                ->onDelete('cascade');

            $table->text('descripcion_otros_servicios_desarrollar')->nullable();

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
        Schema::dropIfExists('pais_servicio_desarrollar_empleabilidad');
    }
};
