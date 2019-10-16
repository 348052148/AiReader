<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'SwaggerController@apidoc');

Route::get('json', 'SwaggerController@getJSON');

Route::prefix("admin")->namespace('Admin')->group(function () {

    Route::get('/', 'AdminController@index');

    Route::get('/books/{page}','BookController@bookList');

    Route::get('/classifys/{page}','ClassifyController@classifyList');
});