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
        Schema::create('casa_dispositivo_socioeconomico', function (Blueprint $table) {
            $table->id();
            $table->foreignId('socioeconomico_id')->constrained('socioeconomicos');
            $table->foreignId('casa_dispositivo_id')->constrained('casa_dispositivos');
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
        Schema::dropIfExists('casa_dispositivo_socioeconomico');
    }
};
