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
        Schema::create('rental_requirements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('customers')->cascadeOnDelete();
            $table->string('resident_id_card')->nullable();
            $table->string('work_or_student_id_card')->nullable();
            $table->string('guarantee_type');
            $table->string('motorcycle_guarantee_doc');
            $table->unsignedInteger('deposit_amount');
            $table->text('social_media_link');
            $table->foreignId('verified_by')->constrained()->cascadeOnDelete();
            $table->timestamp('verified_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rental_requirements');
    }
};
