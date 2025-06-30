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
        Schema::create('pais_pcj_fortalece_areas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pcj_fortalece_area_id')
                ->constrained('pcj_fortalece_areas', 'id');
            $table->foreignId('pais_id')->constrained('paises', 'id')->comment('Pais Id');
            $table->timestamp('active_at')->nullable()->default(null);
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
        Schema::dropIfExists('pais_pcj_fortalece_areas');
    }
};
