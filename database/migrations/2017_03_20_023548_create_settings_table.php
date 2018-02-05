<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->text('value');
            $table->string('description')->nullable();
            $table->char('type_name', 30)->index();
            $table->boolean('is_system')->default(false)->comment('是否为系统配置');
            $table->unsignedInteger('creator_id')->nullable()->default(null);
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
        Schema::dropIfExists('settings');
    }
}
