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
        Schema::create('sesion_titulos', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('titleable_id')->unsigned();
            $table->string('titleable_type');
            $table->foreignId('pais_id')->constrained('paises');
            $table->boolean('titulo_abierto')->default(false);
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
        Schema::dropIfExists('sesion_titulos');
    }
};
