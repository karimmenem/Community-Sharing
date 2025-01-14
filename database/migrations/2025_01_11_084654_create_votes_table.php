<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVotesTable extends Migration
{
    public function up()
    {
        Schema::create('votes', function (Blueprint $table) {
            $table->bigIncrements('voteId'); // Primary key
            $table->unsignedBigInteger('post_id'); // Foreign key to posts table
            $table->unsignedBigInteger('user_id'); // Foreign key to users table
            $table->boolean('vote_type'); // Upvote/Downvote
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('post_id')->references('postId')->on('posts')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            // Unique constraint
            $table->unique(['post_id', 'user_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('votes');
    }
}

