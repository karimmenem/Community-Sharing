<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->bigIncrements('postId'); // Primary key
            $table->unsignedBigInteger('user_id'); // Foreign key to users table
            $table->unsignedBigInteger('categoryId')->nullable(); // Foreign key to categories table
            $table->string('title')->index(); // Indexed for search
            $table->text('description');
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('categoryId')->references('categoryId')->on('categories')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('posts');
    }
}