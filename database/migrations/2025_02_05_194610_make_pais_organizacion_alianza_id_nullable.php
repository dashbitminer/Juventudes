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
        Schema::table('alianzas', function (Blueprint $table) {
            
            $table->dropForeign('fk_organizacion_alianza_pais');
            
            $table->foreignId('pais_organizacion_alianza_id')->nullable()->change();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('alianzas', function (Blueprint $table) {
            //
        });
    }
};
