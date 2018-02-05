<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tags', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('slug', 50)->unique();
            $table->unsignedInteger('creator_id')->nullable()->default(null);
            $table->timestamps();
            $table->foreign('creator_id')
                ->references('id')->on('users')
                ->onUpdate('cascade')
                ->onDelete('set null');
        });

        Schema::create('taggables', function (Blueprint $table) {
            $table->unsignedInteger('tag_id');
            $table->morphs('taggable');

            $table->timestamps();

            $table->foreign('tag_id')
                ->references('id')->on('tags')
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
        Schema::dropIfExists('tags');
        Schema::dropIfExists('taggables');
    }
}
