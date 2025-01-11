<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->bigIncrements('postId'); // Primary key (auto-incrementing postId)
            $table->unsignedBigInteger('user_id'); // Foreign key to users table (referencing id)
            $table->unsignedBigInteger('categoryId'); // Foreign key to categories table (referencing categoryId)
            $table->string('title');
            $table->text('description');
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade'); // Reference to users.id
            $table->foreign('categoryId')->references('categoryId')->on('categories')->onDelete('set null'); // Reference to categories.categoryId
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
