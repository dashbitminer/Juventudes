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
        Schema::create('estipendio_agrupaciones', function (Blueprint $table) {
            $table->id();
            $table->decimal('denominador', 10, 2);
            $table->foreignId('estipendio_id')->constrained('estipendios', 'id', 'fk_estipendio_agrupacion');
            $table->string('color')->nullable()->default(null);
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
        Schema::dropIfExists('estipendio_agrupaciones');
    }
};
