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
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('hello', function () {
   return 'Hello Laravel';
});

//      支持的请求方式
//Route::get($uri, $callback);
//Route::post($uri, $callback);
//Route::put($uri, $callback);
//Route::patch($uri, $callback);
//Route::delete($url, $callback);
//Route::options($url, $callback);

//  指定请求方式
Route::match(['get', 'post', 'put','patch'], 'foo', function () {
    return 'This is a request from get or post';
});

//  允许所有请求方式
Route::any('bar', function () {
   return 'This is a request from any HTTP verb';
});

Route::get('from', function () {
    return '<form method="POST" action="/foo"><input type="hidden" name="_token" value="{{ csrf_token() }}"><button type="submit">提交</button></form>';
});
Route::redirect('/foo','hello', 301);

Route::get('/hey', function () {
   return view('hey', ['website' => 'Laravel']);
});

Route::view('view', 'hey', ['website' => 'Laravel 学院']);

//  {id} 必填参数，{id?}可选参数（需要在闭包参数里设置默认值）
Route::get('user/{id?}', function ($id = null) {
    return 'User ID is ' . $id;
});

Route::get('posts/{post}/comments/{comments}', function ($one, $two) {
    return 'one is ' . $one . ';two is ' . $two;
});

//  正则约束
Route::get('users/{name}/{id}', function ($name, $id) {
    return 'name is ' . $name;
})->where(['id' => '[0-9]+','name' =>'[a-zA-Z]+',]);