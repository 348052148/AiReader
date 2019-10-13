<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Users extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /**
         * avatarUrl: "https://wx.qlogo.cn/mmopen/vi_32/ofE49Kp6ER86w9ic3mGOiancAhdfFHDY5SRkq8khE3F8FSGYWWyG37cKzmF7uErCJEPTEqv0VZszt09kic7d3zm6g/132"
        city: ""
        country: "China"
        gender: 1
        language: "zh_CN"
        nickName: "～～～～～"
        province: ""
         */
        Schema::create('w_users', function (Blueprint $table){
            $table->increments("user_id");
            $table->string('openid', 128);
            $table->string('avatar_url', 256);
            $table->string('city', 128)->nullable();
            $table->string('country', 128)->nullable();
            $table->integer('gender');
            $table->string('language', 128);
            $table->string('nick_name', 128);
            $table->string('province', 128)->nullable();
            $table->timestamp('created_at')->nullable();
            //$table->primary('user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
