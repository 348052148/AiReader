<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    const UPDATED_AT = null;
    //
    protected $table = 'w_books';

    protected $fillable = ['book_id'];

    protected $primaryKey = 'book_id';
}
