<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('notification_from')->nullable();
            $table->foreign('notification_from')->references('id')->on('users')->onDelete('cascade'); 
            $table->unsignedBigInteger('notification_to')->nullable();
            $table->foreign('notification_to')->references('id')->on('users')->onDelete('cascade'); 
            $table->text('notification')->nullable();
            $table->text('notification_type')->nullable();
            // MySQL doesn't allow default values on TEXT/BLOB columns.
            // Use a boolean flag instead.
            $table->boolean('seen')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notifications');
    }
}
