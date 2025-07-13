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
        Schema::table('employees', function (Blueprint $table) {
            // Periksa apakah tabel 'users' memiliki kolom 'full_name'
        if (Schema::hasColumn('employees', 'employees_id')) {
            Schema::table('employees', function (Blueprint $table) {
                // Jika ada, rename kolomnya
                $table->renameColumn('employees_id', 'employee_id');
            });
        }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            //
        });
    }
};
