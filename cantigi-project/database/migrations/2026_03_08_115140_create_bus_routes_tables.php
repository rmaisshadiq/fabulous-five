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
        // Tabel Utama: Rute Bus
        Schema::create('bus_routes', function (Blueprint $table) {
            $table->id();
            $table->string('rute');
            $table->enum('kategori', ['transfer', 'dalam_propinsi', 'overland']);
            $table->integer('min_hari')->default(1);
            $table->timestamps();
        });

        // Tabel Relasi/Pivot: Harga Bus per Tipe
        Schema::create('bus_route_prices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bus_route_id')->constrained('bus_routes')->cascadeOnDelete();
            $table->string('tipe_bus'); // Isinya nanti: 'hiace_elf', 'medium', 'of', 'oh'
            $table->integer('harga');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bus_route_prices');
        Schema::dropIfExists('bus_routes');
    }
};
