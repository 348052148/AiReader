<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//搜索结果
Route::get('/search', 'SearchController@searchBooks');

Route::get('/get', 'IndexController@index');

//获取分类列表
Route::get('/classflys', 'ClassifyController@classifyList');

//获取分类下书籍
Route::get('/classflys/books', 'ClassifyController@classifyBooks');

//获取书籍详情
Route::get('/book/{book_id}', 'BookController@bookDetail');

//获取章节目录
Route::get('/book/{book_id}/chapters', 'BookController@bookChapters');

//获取章节内容
Route::get('/chapter/{chapter_id}/contents', 'BookController@chapterContents');

