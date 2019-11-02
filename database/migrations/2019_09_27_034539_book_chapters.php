<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class BookChapters extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('w_book_chapters', function (Blueprint $table){
            $table->increments("chapter_id");
            //所属书籍
            $table->string('book_id', 128);
            //名称
            $table->string('title', 128);
            //索引
            $table->string('index', 12);
            //url
            $table->string('content_link', 128);
            $table->timestamp('created_at')->nullable();
            $table->index('index', 'index');
            $table->index('book_id', 'book_id');
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
