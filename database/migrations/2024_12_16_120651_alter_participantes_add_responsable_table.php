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
            //NOMBRES
            $table->string('primer_nombre_beneficiario')->nullable()->after('nombre_beneficiario');
            $table->string('segundo_nombre_beneficiario')->nullable()->after('primer_nombre_beneficiario');
            $table->string('tercer_nombre_beneficiario')->nullable()->after('segundo_nombre_beneficiario');
            $table->string('primer_apellido_beneficiario')->nullable()->after('tercer_nombre_beneficiario');
            $table->string('segundo_apellido_beneficiario')->nullable()->after('primer_apellido_beneficiario');
            $table->string('tercer_apellido_beneficiario')->nullable()->after('segundo_apellido_beneficiario');
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
