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
        Schema::create('ficha_empleos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('medio_vida_id')
                ->nullable()
                ->constrained('medio_vidas', 'id', 'fk_ficha_empleos_medio_vida_id');
            $table->foreignId('directorio_id')
                ->nullable()
                ->constrained('directorios', 'id', 'fk_ficha_empleos_directorio_id');
            $table->foreignId('sector_empresa_organizacion_id')
                ->nullable()
                ->constrained('sector_empresa_organizaciones', 'id', 'fk_ficha_empleos_sector_empresa_organizacion_id');
            $table->foreignId('tipo_empleo_id')
                ->nullable()
                ->constrained('tipo_empleos', 'id', 'fk_ficha_empleos_tipo_empleo_id');
            $table->string('cargo')->nullable()->comment('Cargo desempeñado');
            $table->foreignId('salario_id')
                ->nullable()
                ->constrained('salarios', 'id', 'fk_ficha_empleos_salario_id');
            $table->text('habilidades')->nullable();
            $table->string('medio_verificacion_otros')->nullable();
            // relationships medio_verificacion_archivos
            $table->string( 'informacion_adicional')->nullable();
            $table->foreignId('gestor_id')
                ->nullable()
                ->constrained('users', 'id', 'fk_ficha_empleos_gestor_id');
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
        Schema::dropIfExists('ficha_empleos');
    }
};
