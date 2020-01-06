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

//swagger文档
Route::get('/', 'SwaggerController@apidoc');

//swagger文档Json
Route::get('json', 'SwaggerController@getJSON');

//后台管理接口
Route::prefix("admin")->namespace('Admin')->group(function () {

    Route::get('/', 'AdminController@index');

    Route::get('/books/{page}','BookController@bookList');
    Route::post('/books/{bookId}','BookController@updateBook');
    Route::delete('/books/{bookId}','BookController@deleteBook');

    Route::get('/classifys/{page}','ClassifyController@classifyList');

    Route::get('/book/{bookId}/chapters','BookController@bookChapterList');


    Route::get('/users/{page}','UserController@userList');
});

//书籍图片
Route::get('/book/image/{book_id}.jpeg', 'BookController@image');

Route::prefix('reader')->namespace('Reader')->middleware('allow')->group(function (){
    Route::get('/books', 'BookController@books');
});
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
