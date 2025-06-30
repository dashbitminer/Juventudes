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
        Schema::create('pre_alianzas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_organizacion');
            $table->foreignId('pais_id')->constrained('paises', 'id', 'fk_pre_alianza_pais');
            $table->foreignId('pais_organizacion_alianza_id')->constrained('pais_organizacion_alianza', 'id', 'fk_pre_pais_organizacion_alianza');
            $table->string('slug');

            $table->foreignId('gestor_id')->constrained('users', 'id', 'fk_pre_alianza_gestor');
            $table->foreignId('socio_implementador_id')->constrained('socios_implementadores', 'id');

            $table->foreignId('pais_tipo_sector_id')->constrained('pais_tipo_sector', 'id', 'fk_pre_pais_tipo_sector');

            $table->foreignId('pais_tipo_sector_publico_id')->nullable()->constrained('pais_tipo_sector_publico', 'id', 'fk_pre_sector_publico');

            $table->foreignId('pais_tipo_sector_privado_id')->nullable()->constrained('pais_tipo_sector_privado', 'id', 'fk_pre_sector_privado');
            $table->string('otro_tipo_sector_privado')->nullable();
            $table->foreignId('pais_origen_empresa_privada_id')->nullable()->constrained('pais_origen_empresa_privada');
            $table->foreignId('pais_tamano_empresa_privada_id')->nullable()->constrained('pais_tamano_empresa_privada');

            $table->foreignId('pais_tipo_sector_comunitaria_id')->nullable()->constrained('pais_tipo_sector_comunitaria');
            $table->foreignId('pais_tipo_sector_academica_id')->nullable()->constrained('pais_tipo_sector_academica');

            $table->string('nombre_contacto');
            $table->string('cargo_contacto');
            $table->string('telefono_contacto');
            $table->string('email_contacto');
            $table->string('responsable_glasswing');
            $table->text('consideraciones_generales')->nullable();

            $table->foreignId('pais_tipo_alianza_id')->constrained('pais_tipo_alianza');
            $table->text('otros_tipo_alianza')->nullable();

            $table->smallInteger('capacidad_operativa')->nullable()->comment('1: Si, 2: No, 3: No aplica');
            $table->smallInteger('cobertura_geografica')->nullable()->comment('1: Nacional, 2: Internacional, 3: No definido');
            $table->smallInteger('sector')->nullable()->comment('1: Gobierno, 2: Asociación, 3: Organización');

            $table->string('cobertura_internacional')->nullable()->comment('Solo si la cobertura geográfica es internacional');
            //$table->foreignId('departamento_id')->nullable()->constrained('departamentos')->comment('Solo si la cobertura geográfica es nacional');


            $table->decimal('nivel_inversion', 12, 2)->nullable();
            $table->smallInteger('tipo_actor')->nullable()->comment('1: Lobby, 2: Primario, 3: Secundario, 4: No definido');
            $table->smallInteger('nivel_colaboracion')->nullable()->comment('1: Alto, 2: Medio, 3: Bajo, 4: No definido');
            $table->text('servicios_posibles')->nullable();

            $table->smallInteger('espera_de_alianza')->nullable()->comment('1: Costshare, 2: Leverage, 3: Ambas');
            $table->smallInteger('aporte_espera_alianza')->nullable()->comment('Que tipo de aporte se espera de esta alianza (1 Efectivo, 2 En especie, 3 Ambas)');
            $table->decimal('monto_esperado', 12, 2)->nullable();

            $table->decimal('impacto_pontencial', 10, 2)->nullable()->comment('En %');
            $table->text('tipo_impacto_potencial')->nullable();
            $table->text('resultados_esperados')->nullable();

            $table->smallInteger('estado_alianza')->nullable()->comment('1: Atrasado, 2: Cierto nivel de atraso, 3: En tiempo');
            $table->date('fecha_estado_alianza')->nullable();

            $table->string('anio_fiscal_firma')->nullable()->comment('FY24, FY25, FY26, FY27, FY28, FY29, FY30');
            $table->smallInteger('trimestre_aproximado_firma')->nullable()->comment('1: QA, 2: Q2, 3: Q3, 4: Q4');
            $table->text('proximos_pasos')->nullable();

            $table->text('observaciones')->nullable();
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
        Schema::dropIfExists('pre_alianzas');
    }
};
