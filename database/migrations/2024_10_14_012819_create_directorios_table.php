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
        Schema::create('directorios', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->foreignId('pais_id')->nullable()
                ->constrained('paises', 'id', 'fk_directorios_pais_id');
            $table->string('slug')->unique();
            $table->text('descripcion')->nullable();
            $table->string('telefono')->nullable();
            $table->foreignId('tipo_institucion_id')
                ->nullable()
                ->constrained('tipo_instituciones', 'id', 'fk_directorios_tipo_institucion_id');
            $table->string('tipo_institucion_otros')->nullable();
            $table->foreignId('area_intervencion_id')
                ->nullable()
                ->constrained('area_intervenciones', 'id', 'fk_directorios_area_intervencion_id');
            $table->string('area_intervencion_otros')->nullable();
            $table->foreignId('departamento_id')
                ->nullable()
                ->constrained('departamentos', 'id', 'fk_directorioss_departamento_id');
            $table->foreignId('ciudad_id')
                ->nullable()
                ->constrained('ciudades', 'id', 'fk_directorios_ciudad_id');
            $table->text('direccion')->nullable();
            $table->string('ref_nombre')->nullable();
            $table->string('ref_cargo')->nullable();
            $table->string('ref_celular')->nullable();
            $table->string('ref_email')->nullable();
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
        Schema::dropIfExists('directorios');
    }
};
