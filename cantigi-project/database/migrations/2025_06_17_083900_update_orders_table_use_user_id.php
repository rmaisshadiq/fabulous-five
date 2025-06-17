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
        Schema::table('orders', function (Blueprint $table) {
            // Jika kolom customer_id ada, rename ke user_id
            if (Schema::hasColumn('orders', 'customer_id')) {
                $table->renameColumn('customer_id', 'user_id');
            }
            
            // Jika kolom user_id belum ada, tambahkan
            if (!Schema::hasColumn('orders', 'user_id')) {
                $table->unsignedBigInteger('user_id')->after('id');
            }
            
            // Update foreign key constraint
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Drop foreign key constraint
            $table->dropForeign(['user_id']);
            
            // Rename back to customer_id
            $table->renameColumn('user_id', 'customer_id');
            
            // Add back customer foreign key if needed
            // $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
        });
    }
};