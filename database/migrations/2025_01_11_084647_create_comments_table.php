<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentsTable extends Migration
{
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->bigIncrements('commentId'); // Primary key
            $table->unsignedBigInteger('post_id'); // Foreign key to posts table
            $table->unsignedBigInteger('user_id'); // Foreign key to users table
            $table->text('content');
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('post_id')->references('postId')->on('posts')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('comments');
    }
}