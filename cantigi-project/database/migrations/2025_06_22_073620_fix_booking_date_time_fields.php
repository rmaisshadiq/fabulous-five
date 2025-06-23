<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class FixBookingDateTimeFields extends Migration
{
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            // Jika field saat ini adalah datetime, ubah ke date dan time yang terpisah
            $table->date('start_booking_date_new')->nullable();
            $table->date('end_booking_date_new')->nullable();
            $table->time('start_booking_time_new')->nullable();
            $table->time('end_booking_time_new')->nullable();
        });

        // Migrate data dari field lama ke field baru
        DB::statement("
            UPDATE orders SET 
                start_booking_date_new = DATE(start_booking_date),
                end_booking_date_new = DATE(end_booking_date),
                start_booking_time_new = TIME(start_booking_time),
                end_booking_time_new = TIME(end_booking_time)
        ");

        Schema::table('orders', function (Blueprint $table) {
            // Drop field lama
            $table->dropColumn(['start_booking_date', 'end_booking_date', 'start_booking_time', 'end_booking_time']);
            
            // Rename field baru
            $table->renameColumn('start_booking_date_new', 'start_booking_date');
            $table->renameColumn('end_booking_date_new', 'end_booking_date');
            $table->renameColumn('start_booking_time_new', 'start_booking_time');
            $table->renameColumn('end_booking_time_new', 'end_booking_time');
        });
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->datetime('start_booking_date')->change();
            $table->datetime('end_booking_date')->change();
            $table->datetime('start_booking_time')->change();
            $table->datetime('end_booking_time')->change();
        });
    }
}