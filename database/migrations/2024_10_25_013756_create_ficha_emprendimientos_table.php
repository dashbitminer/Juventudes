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
        Schema::create('ficha_emprendimientos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('medio_vida_id')
                ->nullable()
                ->constrained('medio_vidas', 'id', 'fk_ficha_emprendimientos_medio_vida_id');
            $table->string('nombre')->nullable()->comment('Nombre de emprendimiento');
            $table->foreignId('rubro_emprendimiento_id')
                ->nullable()
                ->constrained('rubro_emprendimientos', 'id');
            $table->date('fecha_inicio_emprendimiento')->nullable();
            $table->foreignId('etapa_emprendimiento_id')
                ->nullable()
                ->constrained('etapa_emprendimientos', 'id');
            $table->boolean('tiene_capital_semilla')->nullable()->comment('0: No | 1: Si');
            $table->foreignId('capital_semilla_id')
                ->nullable()
                ->constrained('capital_semillas', 'id');
            $table->string('capital_semilla_otros')->nullable();
            $table->decimal('monto_local', 12, 2)->nullable()->comment('Monto local de cada pais');
            $table->decimal('monto_dolar', 12, 2)->nullable()->comment('Monto local de dolares');
            $table->boolean('tiene_red_emprendimiento')->nullable()->comment('0: No | 1: Si');
            $table->string('red_empredimiento')->nullable();
            // relationship with emprendimiento_medio_verificaciones
            $table->string('medio_verificacion_otros')->nullable();
            $table->text('informacion_adicional')->nullable();
            $table->foreignId('gestor_id')
                ->nullable()
                ->constrained('users', 'id', 'fk_ficha_emprendimientos_gestor_id');
            $table->text('comentario')->nullable();
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
        Schema::dropIfExists('ficha_emprendimientos');
    }
};
