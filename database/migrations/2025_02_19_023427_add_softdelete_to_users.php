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
        Schema::table('users', function (Blueprint $table) {
            $table->softDeletes();

            $table->integer('created_by')
                ->after('deleted_at')
                ->nullable()
                ->default(null);

            $table->integer('updated_by')
                ->after('created_by')
                ->nullable()
                ->default(null);

            $table->integer('deleted_by')
                ->after('updated_by')
                ->nullable()
                ->default(null);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
