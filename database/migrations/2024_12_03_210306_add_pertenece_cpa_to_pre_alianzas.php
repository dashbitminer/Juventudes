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
        Schema::table('pre_alianzas', function (Blueprint $table) {
            $table->smallInteger('pertenece_cpa')
                ->nullable()
                ->after('tipo_actor')
                ->comment('"1" => "Si", "2" => "No", "3" => "No definido"');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pre_alianzas', function (Blueprint $table) {
            //
        });
    }
};
