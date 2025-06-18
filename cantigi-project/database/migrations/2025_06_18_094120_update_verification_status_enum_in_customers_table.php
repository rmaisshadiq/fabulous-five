<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateVerificationStatusEnumInCustomersTable extends Migration
{
    public function up()
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->dropColumn('is_verified');
            $table->enum('verification_status', ['pending', 'verified', 'unverified'])->default('unverified');
        });
    }

    public function down()
    {
        
    }
}
