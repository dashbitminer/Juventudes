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
        Schema::table('sesiones', function (Blueprint $table) {
            $table->tinyInteger('modalidad')
                ->after('grupo_id')
                ->nullable()
                ->comment('1: Presencial, 2: Virtual');

            $table->foreignId('cohorte_pais_proyecto_perfil_id')
                ->after('cohorte_pais_proyecto_id')
                ->nullable()
                ->constrained('cohorte_pais_proyecto_perfil', 'id', 'fk_sesiones_cohorte_pais_proyecto_perfil');

            $table->foreignId('user_id')
                ->after('cohorte_pais_proyecto_perfil_id')
                ->nullable()
                ->constrained('users', 'id', 'fk_sesiones_users');

            // Modificar el tiempo de la sesion
            $table->dropColumn('duracion');

            $table->integer('hora')
                ->after('titulo')
                ->nullable()
                ->comment('Hora de la sesion');

            $table->integer('minuto')
                ->after('hora')
                ->nullable()
                ->comment('Minutos de la sesion');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sesiones', function (Blueprint $table) {
            //
        });
    }
};
