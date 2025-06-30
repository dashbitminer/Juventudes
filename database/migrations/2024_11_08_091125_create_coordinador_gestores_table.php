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
        Schema::create('coordinador_gestores', function (Blueprint $table) {
            $table->id();
            // $table->foreignId('coordinador_id')->constrained('cohorte_socio_users');
            // $table->foreignId('gestor_id')->constrained('cohorte_socio_users');
            $table->foreignId('coordinador_id')->constrained('cohorte_proyecto_user');
            $table->foreignId('gestor_id')->constrained('cohorte_proyecto_user');
            $table->foreignId('cohorte_pais_proyecto_id')->constrained('cohorte_pais_proyecto');
            $table->datetime('active_at')->nullable();
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
        Schema::dropIfExists('coordinador_gestors');
    }
};
