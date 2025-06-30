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
        Schema::create('medio_verificacion_archivos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ficha_empleo_id')
                ->nullable()
                ->constrained('ficha_empleos', 'id');
            $table->foreignId('medio_verificacion_id')
                ->nullable()
                ->constrained('medio_verificaciones', 'id');
            $table->text('documento')->nullable();
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
        Schema::dropIfExists('medio_verificacion_archivos');
    }
};
