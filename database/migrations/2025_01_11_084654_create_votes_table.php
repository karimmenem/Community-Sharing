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
            $table->bigIncrements('voteId'); // Primary key
            $table->unsignedBigInteger('postId'); // Foreign key to posts table
            $table->unsignedBigInteger('userId'); // Foreign key to users table
            $table->boolean('voteType'); // Boolean for upvote/downvote
            $table->timestamps();

            $table->foreign('postId')->references('postId')->on('posts')->onDelete('cascade');
            $table->foreign('userId')->references('userId')->on('users')->onDelete('cascade');
            $table->unique(['postId', 'userId']);
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
