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
        Schema::create('cost_share_area_cobertura', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cost_share_id')->constrained()->comment('Cost Share Id')->name('fk_costshare_areacobertura');
            $table->foreignId('departamento_id')->constrained()->comment('Area Cobertura Id');
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
        Schema::dropIfExists('cost_share_area_cobertura');
    }
};
