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
        Schema::create('cohorte_proyecto_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cohorte_pais_proyecto_id')->constrained('cohorte_pais_proyecto');
            $table->foreignId('user_id')->constrained('users');
            $table->string('rol', 50)->nullable();
            $table->datetime('active_at')->nullable();
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
        Schema::dropIfExists('cohorte_proyecto_user');
    }
};
