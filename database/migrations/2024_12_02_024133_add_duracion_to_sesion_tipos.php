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
        Schema::table('sesion_tipos', function (Blueprint $table) {
            $table->dropForeign(['pais_id']);
            $table->dropColumn('pais_id');

            $table->foreignId('cohorte_pais_proyecto_id')
                ->after('typesable_type')
                ->nullable()
                ->constrained('cohorte_pais_proyecto', 'id', 'fk_sesion_tipos_cohorte_pais_proyecto')
                ->onDelete('cascade');

            $table->decimal('duracion', 8, 2)
                ->after('tipo')
                ->nullable()
                ->comment('Duración de la sesión en horas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sesion_tipos', function (Blueprint $table) {
            //
        });
    }
};
