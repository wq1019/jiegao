<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttachmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attachments', function (Blueprint $table) {
            $table->increments('id');
            // $table->unsignedInteger('post_id')->index()->nullable()->default(null)->comment('文章 id');
            $table->unsignedInteger('uploader_id')->nullable()->default(null)->comment('上传者id');
            $table->string('title');
            $table->string('mime');
            $table->unsignedInteger('file_size');
            $table->string('path');
            $table->timestamps();

            $table->foreign('uploader_id')
                ->references('id')->on('users')
                ->onUpdate('cascade')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attachments');
    }
}
