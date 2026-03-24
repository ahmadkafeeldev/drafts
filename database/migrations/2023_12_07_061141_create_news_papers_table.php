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
        Schema::create('news_papers', function (Blueprint $table) {
            $table->id();
            $table->string('name')->default("");
            $table->string('email')->default("");
            $table->string('borough')->default("");
            $table->string('booking_deadline')->default("");
            $table->string('publish_date')->default("");
            $table->string('news_group')->default("");
            $table->string('area')->default("");
            $table->string('rate')->default("");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('news_papers');
    }
};
