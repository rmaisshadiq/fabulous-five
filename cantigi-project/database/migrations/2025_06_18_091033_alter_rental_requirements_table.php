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
        Schema::table('rental_requirements', function (Blueprint $table) {
            // Drop the foreign key constraint first
            $table->dropForeign(['verified_by']);

            // Modify the column to be nullable
            $table->foreignId('verified_by')->nullable()->change();

            // Re-add the foreign key constraint
            $table->foreign('verified_by')->references('id')->on('employees')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rental_requirements', function (Blueprint $table) {
            $table->dropForeign(['verified_by']);
            $table->foreignId('verified_by')->nullable(false)->change();
            $table->foreign('verified_by')->references('id')->on('employees')->onDelete('cascade');
        });
    }
};
