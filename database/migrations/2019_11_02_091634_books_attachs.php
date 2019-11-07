<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class BooksAttachs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('w_books_attach', function (Blueprint $table){
            $table->increments("book_attach_id");
            $table->string('book_id', 128)->default("");
            $table->integer('read_times');
            $table->integer('look_times');
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
