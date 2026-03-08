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
        Schema::table('vehicles', function (Blueprint $table) {
            $table->boolean('is_best_deal')->default(false); // Penanda promo
            $table->integer('harga_drop_bandara')->nullable();
            $table->integer('harga_city_tour')->nullable();
            $table->integer('harga_full_day')->nullable();
            $table->integer('harga_luar_kota')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vehicles', function (Blueprint $table) {
            $table->dropColumn(['is_best_deal', 'harga_drop_bandara', 'harga_city_tour', 'harga_full_day', 'harga_luar_kota']);
        });
    }
};
