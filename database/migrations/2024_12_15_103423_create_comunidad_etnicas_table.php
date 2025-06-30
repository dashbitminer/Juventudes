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
        Schema::create('comunidad_etnicas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('grupo_etnico_id')->constrained('grupo_etnicos', 'id', 'fk_comunidad_etnicas_grupo_etnico');
            $table->string('nombre');
            $table->string('slug')->unique();
            $table->text('comentario')->nullable();
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
        Schema::dropIfExists('comunidad_etnicas');
    }
};
