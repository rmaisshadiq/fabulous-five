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
            $table->decimal('fuel_level_on_rent', 5, 2)
                ->nullable()
                ->after('returned_at');
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
