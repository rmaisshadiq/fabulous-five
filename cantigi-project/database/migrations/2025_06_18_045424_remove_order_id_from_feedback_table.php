<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveOrderIdFromFeedbackTable extends Migration
{
    public function up()
    {
        Schema::table('feedback', function (Blueprint $table) {
            // Hapus foreign key constraint dulu
            $table->dropForeign(['order_id']);

            // Baru hapus kolomnya
            $table->dropColumn('order_id');
        });
    }

    public function down()
    {
        Schema::table('feedback', function (Blueprint $table) {
            // Tambahkan kembali kolomnya
            $table->unsignedBigInteger('order_id')->nullable();

            // Tambahkan kembali foreign key-nya jika perlu
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
        });
    }
}
