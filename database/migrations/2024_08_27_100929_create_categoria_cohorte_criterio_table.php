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
        Schema::create('categoria_cohorte_criterio', function (Blueprint $table) {
            $table->id();
            $table->foreignId('categoria_participante_id')->constrained('categoria_participantes')->comment('Categoria a la que pertenece el criterio');
            $table->foreignId('cohorte_id')->constrained()->comment('Cohorte a la que pertenece el criterio');
            $table->foreignId('criterio_id')->constrained()->comment('Criterio que pertenece a la categoria');

            $table->string('operador')->comment('Operador de comparación');
            $table->integer('valor')->comment('Valor a comparar');

            $table->datetime('active_at')->nullable();
            $table->text('comentario')->nullable();
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
        Schema::dropIfExists('categoria_cohorte_criterio');
    }
};
