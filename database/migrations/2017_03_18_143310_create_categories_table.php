<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->increments('id');
            $table->char('type', 10)->comment('分类类型 post: 列表栏目 page: 单页栏目 link: 外部链接');
            $table->string('image')->nullable()->comment('分类图片');
            // 父级id
            $table->unsignedInteger('parent_id')->default(0)->comment('父级id');
            // 分类名
            $table->string('cate_name')->unique()->comment('分类名');
            // 分类描述
            $table->string('description', 512)->nullable()->comment('分类描述');
            // 外部链接
            $table->string('url')->nullable()->comment('外部链接');
            // 链接是否在新窗口打开
            $table->boolean('is_target_blank')->default(true)->comment('链接是否在新窗口打开');
            // 分类slug
            $table->string('cate_slug')->unique()->commnet('分类slug');
            // 是否在导航栏显示
            $table->boolean('is_nav')->default(false)->comment('是否在导航栏显示');
            $table->integer('order')->default(0)->index()->comment('排序字段');
            // 单页模板
            $table->string('page_template', 30)->nullable()->comment('单页模板');
            // 列表页模板
            $table->string('list_template', 30)->nullable()->comment('列表页模板');
            // 默认内容模板
            $table->string('content_template', 30)->nullable()->comment('默认内容模板');
            $table->unsignedInteger('creator_id')->nullable()->default(null);

            // 分类的一些其他配置
            // $table->mediumText('setting')->nullable();
            $table->timestamps();

            $table->foreign('creator_id')
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
        Schema::dropIfExists('categories');
    }
}
