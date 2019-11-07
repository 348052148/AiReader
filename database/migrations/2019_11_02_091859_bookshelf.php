<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Bookshelf extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('w_bookshelf', function (Blueprint $table) {
            $table->integer('user_id');     // 用户id
            $table->string('book_id', 128);             // 书籍id
            $table->integer('read_num');    // 读取记录
            $table->integer('read_offset'); // 读取记录
            $table->tinyInteger('is_updated'); //是否更新
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
