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
        Schema::create('estipendios', function (Blueprint $table) {
            $table->id();
            // $table->string('nombre');
            // $table->string('descripcion')->nullable()->default(null);
            $table->foreignId('cohorte_pais_proyecto_id')->constrained('cohorte_pais_proyecto', 'id', 'fk_estipendio_cohorte_pais_proyecto');
            $table->foreignId('socio_implementador_id')->constrained('socios_implementadores', 'id', 'fk_estipendio_socio_implementador');
            $table->foreignId('perfil_participante_id')->constrained('perfiles_participantes', 'id', 'fk_estipendio_perfil_participante');
            // $table->foreignId('cohorte_pais_proyecto_perfil_id')->nullable()->default(null)
            //     ->constrained('cohorte_pais_proyecto_perfiles', 'id', 'fk_estipendio_cohorte_pais_proyecto_perfil');
            $table->smallInteger('mes');
            $table->year('anio');
            $table->date('fecha_inicio');
            $table->date('fecha_fin');
            $table->timestamp('active_at')->nullable()->default(null);
            $table->timestamp('aprobado')->nullable()->default(null);
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
        Schema::dropIfExists('estipendios');
    }
};
