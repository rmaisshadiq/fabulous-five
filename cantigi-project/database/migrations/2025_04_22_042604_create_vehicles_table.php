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
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->string('car_type');
            $table->string('brand');
            $table->string('model');
            $table->string('vehicle_image');
            $table->string('license_plate')->unique();
            $table->decimal('price_per_day');
            $table->date('purchase_date')->default(date("Y-m-d"));
            $table->date('last_maintenance_date')->default(date("Y-m-d"));
            $table->enum('status', ['active', 'maintenance', 'retired']);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
