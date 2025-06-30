<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\SesionTipo;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sesion_tipos', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('typesable_id')->unsigned();
            $table->string('typesable_type');
            $table->foreignId('pais_id')->constrained('paises');
            $table->tinyInteger('tipo')->default(SesionTipo::SESION_GENERAL)->comment('0 Sesion General | 1 Horas por Participante');
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
        Schema::dropIfExists('sesion_tipos');
    }
};
