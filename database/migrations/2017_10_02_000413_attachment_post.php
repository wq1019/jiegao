<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AttachmentPost extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attachment_post', function (Blueprint $table) {
            $table->unsignedInteger('attachment_id');
            $table->unsignedInteger('post_id');

            $table->foreign('attachment_id')->references('id')->on('attachments')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('post_id')->references('id')->on('posts')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->primary(['attachment_id', 'post_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attachment_post');
    }
}
