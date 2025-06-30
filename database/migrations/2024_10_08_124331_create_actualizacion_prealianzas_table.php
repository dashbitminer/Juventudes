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
        Schema::create('actualizacion_prealianzas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('prealianza_id')->constrained('pre_alianzas', 'id');
            $table->smallInteger('estado_alianza')->nullable()->comment('1: Atrasado, 2: Cierto nivel de atraso, 3: En tiempo');
            $table->dateTime('fecha_actualizacion')->nullable();
            $table->text('proximos_pasos')->nullable();
            $table->text('observaciones')->nullable();
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
        Schema::dropIfExists('actualizacion_prealianzas');
    }
};
