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
        Schema::create('bancarizacion_grupo_participantes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bancarizacion_grupo_id')->constrained('bancarizacion_grupos');
            $table->foreignId('participante_id')->constrained('participantes');
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
        Schema::dropIfExists('bancarizacion_grupo_participantes');
    }
};
