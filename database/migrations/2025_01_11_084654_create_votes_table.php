<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('votes', function (Blueprint $table) {
            $table->bigIncrements('voteId'); // Primary key (auto-incrementing voteId)
            $table->unsignedBigInteger('post_id'); // Foreign key to posts table (referencing postId)
            $table->unsignedBigInteger('user_id'); // Foreign key to users table (referencing id)
            $table->boolean('vote_type'); // Boolean for upvote/downvote
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('post_id')->references('postId')->on('posts')->onDelete('cascade'); // Reference to posts.postId
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade'); // Reference to users.id
            $table->unique(['post_id', 'user_id']); // Unique constraint to prevent multiple votes by same user on the same post
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('votes');
    }
}
