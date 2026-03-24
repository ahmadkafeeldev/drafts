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
        Schema::create('draft_bookings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('news_paper_id')->nullable();
            $table->foreign('news_paper_id')->references('id')->on('news_papers')->onDelete('cascade');
            $table->string('london_gazette')->default("");
            $table->string('title')->default("");
            $table->string('area')->nullable();
            $table->string('borough')->default("");
            $table->string('publish_date')->default("");
            $table->string('booking_date')->nullable();
            $table->string('document')->default("");
            $table->integer('price')->default(0);
            $table->string('currency_symbol')->default("€");
            $table->string('booking_type')->default("");
            $table->string('notice_type')->default("");
            $table->string('status')->default("");
            $table->string('proof_pdf')->default("");
            $table->string('pdf_status')->default("");
            $table->string('payment_invoice')->default("");
            $table->string('payment_recipt')->default("");
            $table->string('payment_status')->default("");
            $table->string('assign_to')->default("");
            $table->string('delivery_status')->default("");
            $table->string('delivery_proof')->default("");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('draft_bookings');
    }
};
