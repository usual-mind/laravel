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

//  路由请求方式
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
})->name('hey');

Route::view('view', 'hey', ['website' => 'Laravel 学院']);

//  路由参数
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
})->where(['id' => '[0-9]+','name' =>'[a-zA-Z]+',])->name('users');


//  命名路由

//  根据已知路由名称，生成对应的URL
Route::get('user/{id}/profile', function ($id) {
    $url = route('users', [$id,4]);
    return $url;
})->name('profile');

//route()  和  TP中的U方法   功能类似


//  根据已知路由名称，重定向到  对应的URL
Route::get('redirect', function () {
    return redirect()->route('hey');
});

//  路由分组

//  中间件
Route::middleware(['first', 'second'])->group(function () {
    Route::get('/', function () {
        //  TODO
    });

    Route::get('user/profile', function () {
        //  TODO
    });
});

//  命名空间
Route::namespace('Admin')->group(function () {
    //  Controller Within The "App\Http\Controllers\Admin" Namespace
});

//  子域名路由
Route::domain('{account}.blog.dev')->group(function () {
   Route::get('user/{id}', function ($account, $id) {
       return 'This is ' . $account . ' page of User ' . $id;
   });
});

//  路由前缀
Route::prefix('admin')->group(function () {
    Route::get('users', function () {
        return 'This is prefix route';
    });
});

//  中间件
Route::group(['middleware' => 'token'], function () {
    Route::get('middle', function () {
        return 'this is middleware';
    });
});

//  中间件参数，验证角色CheckRole
Route::put('post/{id}', function ($id) {
    //
})->middleware('role:editor');



//  CSRF 验证
Route::get('form_without_csrf_token', function (){
    return '<form method="POST" action="/hello_from_form"><button type="submit">提交</button></form>';
});

Route::get('form_with_csrf_token', function () {
    return '<form method="POST" action="/hello_from_form">' . csrf_field() . '<button type="submit">提交</button></form>';
});

Route::post('hello_from_form', function (){
    return 'hello laravel!';
});