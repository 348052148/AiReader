<?php

namespace App;


class User extends \Illuminate\Foundation\Auth\User
{
    protected $table = "w_users";

    protected $fillable = ['phone', 'password', 'api_token', 'nick_name'];

    protected $primaryKey = 'user_id';
}
