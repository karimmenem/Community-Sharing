<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->bigIncrements('commentId'); // Primary key (auto-incrementing commentId)
            $table->unsignedBigInteger('post_id'); // Foreign key to posts table (referencing postId)
            $table->unsignedBigInteger('user_id'); // Foreign key to users table (referencing id)
            $table->text('content');
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('post_id')->references('postId')->on('posts')->onDelete('cascade'); // Reference to posts.postId
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade'); // Reference to users.id
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comments');
    }
}
