<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBannersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('banners', function (Blueprint $table) {
            $table->increments('id');
            $table->string('url')->nullable();
            $table->string('title')->nullable();
            $table->string('image');
            $table->char('type_name', 30)->index();
            $table->boolean('is_visible')->default(true);
            $table->unsignedInteger('creator_id')->nullable()->default(null);

            // todo $table->boolean('is_target_blank')->default(true)->comment('链接是否在新窗口打开');
            // todo 启用时间
            // todo $table->timestamp('enabled_at')->nullable();
            // todo 过期时间
            // todo $table->timestamp('expired_at')->nullable();
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
        Schema::dropIfExists('banners');
    }
}
