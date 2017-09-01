<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tag', function(Blueprint $table) {
            $table->increments('id');
            $table->string('name', 50);
        });

        Schema::create('news_tags', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('news_id')->unsigned();
            $table->integer('tag_id')->unsigned();

            $table->foreign('news_id')->references('id')->on('news')->onDelete('cascade');
            $table->foreign('tag_id')->references('id')->on('tag');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('news_tags', function(Blueprint $table) {
            $table->dropForeign(['news_id']);
            $table->dropForeign(['tag_id']);
        });
        Schema::dropIfExists('tag');
        Schema::dropIfExists('news_tags');
    }
}
