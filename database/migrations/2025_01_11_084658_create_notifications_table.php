<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationsTable extends Migration
{
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->bigIncrements('notification_id'); // Primary key
            $table->unsignedBigInteger('user_id'); // Foreign key to users table
            $table->text('message');
            $table->boolean('is_read')->default(false);
            $table->timestamps();

            // Foreign key reference
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            // Index for efficient unread notifications query
            $table->index('is_read');
        });
    }

    public function down()
    {
        Schema::dropIfExists('notifications');
    }
}