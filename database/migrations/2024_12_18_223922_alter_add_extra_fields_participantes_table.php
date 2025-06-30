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
        Schema::table('participantes', function (Blueprint $table) {
            $table->smallInteger('tiempo_atender_actividades')->nullable()->after('nivel_educativo_alcanzado')
                ->comment("1: si, 2: no, 3: no sabe");

            $table->smallInteger('ultimo_anio_estudio')->nullable()->after('tiempo_atender_actividades')->comment('¿Cuál fue el último año en el que estudió?');
            $table->boolean('continuidad_tres_meses')->nullable()->after('ultimo_anio_estudio')->comment('¿Se inscribirá para continuar con sus estudios en un lapso no mayor a 3 meses?');
            $table->boolean('pariente_participo_jovenes_proposito')->nullable()->after('continuidad_tres_meses')->comment('¿Algún pariente ha participado en Jóvenes con Propósito?');
            $table->smallInteger('parentesco_pariente_parcicipo_jovenes_proposito')->nullable()->after('pariente_participo_jovenes_proposito')
                    ->comment('1: Hernmana/o, 2: Prima/o, 3: Tía/o, 4: Otros');
            $table->string('pariente_participo_otros')->nullable()->after('parentesco_pariente_parcicipo_jovenes_proposito')->comment('¿Cuál es el parentesco del pariente que participó? (Si seleccionó "Otro")');

            $table->string('copia_documento_identidad_reverso')->nullable()->after('copia_documento_identidad')->comment('Copia de documento de identidad (reverso)');
            $table->string('copia_compromiso_continuar_estudio')->nullable()->after('copia_constancia_estudios')->comment('Copia de compromiso de continuar estudios');
            $table->text('comentario_compromiso_continuar_estudio')->nullable()->after('comentario_formulario_consentimiento_programa_upload')->comment('Comentario de compromiso de continuar estudios');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('participantes', function (Blueprint $table) {
            //
        });
    }
};
