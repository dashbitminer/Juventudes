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
        Schema::create('pais_organizacion_alianza', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pais_id')->constrained('paises')->comment('País Id');
            $table->foreignId('organizacion_alianza_id')
                    ->constrained('organizacion_alianzas','id', 'fk_organizacion_alianza')
                    ->comment('Organizacion Alianza Id');
            $table->string('telefono')->nullable();
            $table->string('email')->nullable();
            $table->string('nombre_contacto')->nullable();
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
        Schema::dropIfExists('pais_organizacion_alianza');
    }
};
