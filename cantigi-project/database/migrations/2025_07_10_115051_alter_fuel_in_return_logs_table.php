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
        Schema::table('return_logs', function (Blueprint $table) {
            $table->string('fuel_level_on_rent')->nullable()->change();
            $table->string('fuel_level_on_return')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('return_logs', function (Blueprint $table) {
            //
        });
    }
};
