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
            $table->increments('id');
            $table->unsignedInteger('user_id')->index();
            $table->string('title');
            // slug
            $table->string('slug')->unique();
            // 摘要
            $table->string('excerpt', 512)->nullable();
            // 文章封面
            $table->string('cover')->nullable()->comment('文章封面');
            $table->unsignedInteger('category_id')->index()->comment('分类 id');
            $table->char('status', 10)->default('publish')->comment('文章状态：publish 发布 draft 草稿');
            // 类型
            $table->char('type', 10)->default('post')->comment('类型: post 文章 page 单页');
            // 浏览量
            $table->unsignedInteger('views_count')->default(0)->index();
            // 文章置顶
            $table->timestamp('top')->nullable()->index();
            $table->integer('order')->default(0)->index()->comment('排序字段');
            // 内容模板
            $table->string('template')->nullable();

            $table->softDeletes();
            // 发布时间
            $table->timestamp('published_at')->nullable();
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
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
