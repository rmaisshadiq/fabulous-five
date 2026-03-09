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
        Schema::disableForeignKeyConstraints();

        Schema::dropIfExists("customers");
        Schema::dropIfExists("drivers");
        Schema::dropIfExists("employees");
        Schema::dropIfExists("feedback");
        Schema::dropIfExists("financial_reports");
        Schema::dropIfExists("imports");
        Schema::dropIfExists("maintenances");
        Schema::dropIfExists("orders");
        Schema::dropIfExists("order_reports");
        Schema::dropIfExists("payments");
        Schema::dropIfExists("rental_requirements");
        Schema::dropIfExists("return_logs");

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
