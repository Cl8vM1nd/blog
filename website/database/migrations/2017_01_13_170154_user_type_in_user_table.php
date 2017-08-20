<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UserTypeInUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user', function(Blueprint $table) {
            $table->integer('type')
                ->unsigned()
                ->after('password')
                ->default(2);

            $table->foreign('type')->references('id')->on('user_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user', function(Blueprint $table) {
            $table->dropForeign('user_type_foreign');
            $table->dropColumn('type');
        });
    }
}
