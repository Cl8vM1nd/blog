<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UserType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_type', function(Blueprint $table) {
            $table->increments('id');
            $table->string('name', 100);
        });

        DB::table('user_type')->insert([
            [
                'name' => 'Admin',
            ], [
                'name' => 'User',
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExist('user_type');
    }
}
