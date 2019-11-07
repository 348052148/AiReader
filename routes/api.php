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

Route::get('/', 'IndexController@index');

//搜索结果
Route::get('/search', 'SearchController@searchBooks');

//复合搜索
Route::get('/book/search', 'SearchController@searchMixedBooks');

//获取热门书籍
Route::get('/hot/books', 'IndexController@hotBooks');

//获取推荐书籍
Route::get('/recommend/books', 'IndexController@recommendBooks');

//聚合首页数据
Route::get('/home/books', 'IndexController@homeBooks');

//获取bannar
Route::get('/bannar/list', 'IndexController@bannarBooks');

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

//获取类似的推荐书籍
Route::get('/book/{book_id}/recommends', 'BookController@recommendAsBooks');

//获取章节内容
Route::get('/chapter/{chapter_id}/contents', 'BookController@chapterContents');

//获取书籍指定索引章节内容
Route::get('/book/{book_id}/chapter/{index}/contents', 'BookController@chapterContentsByIndex');

//获取书籍封面图
Route::get('/book/{book_id}/image', 'BookController@image');

//用户信息
Route::get('/user/{openid}', 'UserController@userInfo');

//用户书架
Route::get('/user/{user_id}/bookshelf', 'UserController@userBookShelf');
Route::post('/user/{user_id}/bookshelf', 'UserController@addBookForBookShelf');
Route::delete('/user/{user_id}/bookshelf', 'UserController@removeBookForBookShelf');

//小程序登陆
Route::get('/wechat/login/{code}', 'LoginController@login');
Route::post('/wechat/register', 'LoginController@register');

