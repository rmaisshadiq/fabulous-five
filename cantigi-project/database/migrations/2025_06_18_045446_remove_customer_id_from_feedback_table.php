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
        Schema::table('feedback', function (Blueprint $table) {
            // Hapus foreign key terlebih dahulu jika ada
            $table->dropForeign(['customer_id']);

            // Baru hapus kolom
            $table->dropColumn('customer_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('feedback', function (Blueprint $table) {
            $table->unsignedBigInteger('customer_id')->nullable();

            // Tambahkan foreign key kembali jika diperlukan
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
        });
    }
};
