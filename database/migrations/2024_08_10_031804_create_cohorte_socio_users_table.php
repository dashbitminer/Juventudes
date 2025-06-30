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
        Schema::create('cohorte_socio_users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cohorte_id')->constrained('cohortes');
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('socios_implementador_id')->constrained('socios_implementadores');
            $table->string('rol')->comment('rol del usuario en la cohorte');
            $table->text('comentario')->nullable();
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
        Schema::dropIfExists('cohorte_users');
    }
};
