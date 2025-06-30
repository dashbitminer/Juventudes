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
        Schema::create('participante_responsabilidad_hijo', function (Blueprint $table) {
            $table->id();
            //$table->foreignId('comparte_responsabilidad_hijo_id')->constrained('comparte_responsabilidad_hijos')->onDelete('cascade');
            $table->foreignId('comparte_responsabilidad_hijo_id')->constrained(
                table: 'comparte_responsabilidad_hijos', indexName: 'fk_comparte_reportabilidad_hijo'
            )->onDelete('cascade');
            $table->foreignId('participante_id')->constrained('participantes')->onDelete('cascade');
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
        Schema::dropIfExists('participante_responsabilidad_hijo');
    }
};
