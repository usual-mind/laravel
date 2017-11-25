<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
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

Route::get('bar', function () {
   return 'This is a request from get Api';
});

Route::get('users/{user}', function (App\User $user){
    dd($user);
});

//  API资源路由
//  声明被 API 消费的资源路由时，
//你可能需要排除展示 HTML 模板的路由，
//如 create 和 edit，为了方便起见，
//Laravel 提供了 apiResource 方法自动排除这两个路由：
Route::apiResource('post', 'PostController');