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
        Schema::table('financial_reports', function (Blueprint $table) {
            $table->foreignId('maintenance_id')
                ->nullable()
                ->constrained('maintenances')
                ->after('id');
            $table->foreignId('order_id')
                ->nullable()
                ->constrained('orders')
                ->after('maintenance_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('financial_reports', function (Blueprint $table) {
            //
        });
    }
};
