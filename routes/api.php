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

Route::get('/image', 'ImageController@image');

//搜索结果
Route::get('/search', 'SearchController@searchBooks');

//复合搜索
Route::get('/book/search', 'SearchController@searchMixedBooks');

//获取热门书籍
Route::get('/hot/books', 'IndexController@hotBooks');

//获取推荐书籍
Route::get('/recommend/books', 'IndexController@recommendBooks');

//获取所有书籍
Route::get('/book/all', 'IndexController@index');

//获取分类列表
Route::get('/classifys', 'ClassifyController@classifyList');

//获取分类下书籍
Route::get('/classifys/books', 'ClassifyController@classifyBooks');

//获取书籍详情
Route::get('/book/{book_id}', 'BookController@bookDetail');

//获取章节目录
Route::get('/book/{book_id}/chapters', 'BookController@bookChapters');

//获取章节内容
Route::get('/chapter/{chapter_id}/contents', 'BookController@chapterContents');

//小程序登陆
Route::get('/wechat/login/{code}', 'LoginController@login');
Route::post('/wechat/register', 'LoginController@register');

