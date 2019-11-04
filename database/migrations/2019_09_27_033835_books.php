<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Books extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('w_books', function (Blueprint $table){
            $table->string('book_id', 128);
            //分类id
            $table->integer('classify_id');
            //标题
            $table->string('title', 128);
            //作者
            $table->string('author', 12);
            //详情
            $table->text('detail');
            //连载状态
            $table->string('status', 10);
            //封面图
            $table->string('cover', 256);
            //urL
            $table->string('chapter_link', 128);
            //源站名称
            $table->string('source', 128);
            $table->timestamp('created_at')->nullable();
            //主键索引
            $table->primary("book_id");
            $table->index('title', 'title');
            $table->index('author', 'author');
            $table->index('status', 'status');
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
