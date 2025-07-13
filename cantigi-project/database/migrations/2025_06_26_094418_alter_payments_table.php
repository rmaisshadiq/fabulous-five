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
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn('transaction_id');
            $table->dropColumn('payment_date');
            $table->dropColumn('payment_method');
            $table->dropColumn('payment_data');
            $table->string('midtrans_transaction_id')
                ->unique()
                ->nullable()
                ->after('order_id');
            $table->string('midtrans_order_id')
                ->nullable()
                ->after('midtrans_transaction_id');
            $table->string('payment_type')
                ->nullable()
                ->after('status');
            $table->dateTime('transaction_time')
                ->nullable()
                ->after('payment_type');
            $table->string('signature_key')
                ->after('transaction_time')
                ->nullable();
            $table->json('raw_response')
                ->after('signature_key')
                ->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
