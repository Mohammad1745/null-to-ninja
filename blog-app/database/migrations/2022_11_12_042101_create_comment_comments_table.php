<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comment_comments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('post_comment_id');
            $table->unsignedBigInteger('user_id');
            $table->string('content');
            $table->timestamps();

            $table->foreign('post_comment_id')->references('id')->on('post_comments')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comment_comments');
    }
};
