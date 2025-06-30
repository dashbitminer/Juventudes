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
        Schema::table('cost_shares', function (Blueprint $table) {
                $table->integer('es_nueva_organizacion')
                ->after('tipo_organizacion');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cost_shares', function (Blueprint $table) {
            //
        });
    }
};
