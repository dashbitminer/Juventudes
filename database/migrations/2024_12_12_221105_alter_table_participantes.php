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
            $table->string('primer_nombre')->nullable()->after('apellidos');
            $table->string('segundo_nombre')->nullable()->after('primer_nombre');
            $table->string('tercer_nombre')->nullable()->after('segundo_nombre');
            $table->string('primer_apellido')->nullable()->after('tercer_nombre');
            $table->string('segundo_apellido')->nullable()->after('primer_apellido');
            $table->string('tercer_apellido')->nullable()->after('segundo_apellido');

            // //DIRECCION
            // $table->text('direccion')->nullable();
            // $table->string('casa')->nullable();
            // $table->string('apartamento')->nullable();
            // $table->string('zona')->nullable();

            // $table->string('colonia')->nullable(); // tambien guate y honduras
            // $table->string('calle')->nullable(); // honduras
            // $table->string('sector')->nullable(); // honduras
            // $table->string('bloque')->nullable(); // honduras
            // $table->string('punto_referencia')->nullable(); // honduras
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
