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

//Route::get('/', function () {
//    return view('welcome');
//});

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
//  重定向  （原链接，新链接，状态码）
Route::redirect('/foo','hello', 301);

//  访问页面的两种方式
Route::get('/hey', function () {
   return view('hey', ['website' => '中间件验证失败']);
})->name('hey');

Route::view('view', 'hey', ['website' => 'Laravel 学院']);

//  路由参数
//  {id} 必填参数，{id?}可选参数（需要在闭包参数里设置默认值）
//Route::get('user/{id?}', function ($id = null) {
//    return 'User ID is ' . $id;
//});

//  路由参数绑定(隐式绑定)
//  由于类型声明了 Eloquent 模型 App\User，
//  对应的变量名 $user 会匹配路由片段中的 {user}，
//  这样，Laravel 会自动注入与请求 URI 中传入的 ID 对应的用户模型实例。
//  主要是 模型声明的变量名 $test，要与路由参数名 {test} 一致
Route::get('user/{test}', function (\App\User $test) {
    dd($test);
})->name('test');

//  显示绑定(注册了显示绑定之后，隐式绑定依然可用)
//Route::get('user/{user_model}', function (\App\User $user) {
//    dd($user);
//});

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


//  访问控制器
Route::prefix('controller')->group(function () {
    Route::get('user/{id}', 'UserController@show');
    //通过 __invoke() 方法实现单动作控制器
    Route::get('show/{id}', 'ShowProfile');
    Route::get('test', 'UserController@test');
});

//  资源控制器
//Route::resource('posts', 'PostController');

//  指定路由处理的动作子集
//  允许
//Route::resource('post', 'PostController', ['only' => ['index', 'show']]);
////  允许除此以外的方法
//Route::resource('post','PostController',  ['except' => ['create', 'store', 'update', 'destroy']]);

//  命名资源路由

Route::resource('posts', 'PostController', ['names' => ['create' => 'posts.build']]);
Route::get('re_posts', function () {
    return redirect()->route('posts.build');
});

//  参考  命名路由
//Route::get('/hey', function () {
//    return view('hey', ['website' => '中间件验证失败']);
//})->name('hey');

//  命名用处
//  使用route()生成URL


//  补充资源控制器(一定要在 该Route::resource 之前定义，否则会被覆盖)
Route::get('admin_use/build', 'PostController@build');

//  命名资源路由参数
Route::resource('admin_use', 'PostController', ['names' => ['create' => 'admin'],'parameters' => ['user' => 'admin_user']]);
Route::get('admins', function () {
    return route('admin');
});

//  依赖注入测试
Route::post('userss', 'UserController@store');
//  依赖注入 和 路由参数 共同使用
//  需要将路由参数置于其它依赖之后
//Route::post('userss/{id}', 'UserController@store');

//  依赖注入（edit方法  注入User模型，可实现路由模型绑定的功能）
Route::get('user_edit/{user}', 'UserController@edit');

//  通过路由闭包访问请求
use Illuminate\Http\Request;
Route::post('request', function (Request $request) {
//    dd($request);
    $result = array(
        //  返回 POST + GET  参数组
        'input1' => $request->input(),
        //  返回其值
        'input2' => $request->name,
        //  返回 POST参数组
        'post' => $request->post(),
        //  返回  GET参数组
        'query' => $request->query(),
        //  返回 POST + GET 指定参数值
        'get' => $request->get('name'),
        //  返回 POST + GET 除指定参数外的参数组
        //  注：only 方法返回所有你想要获取的参数键值对，不过，如果你想要获取的参数不存在，则对应参数会被过滤掉。
        'except' => $request->except('name'),
        //  返回 POST + GET 指定参数组
        'only' => $request->only('name','sex'),
        //  请求的路径信息
        $request->path(),
        //  验证请求路径是否与给定模式匹配
        $request->is('request'),
        //  返回完整URL  不带参数
        'url' => $request->url(),
        //  返回完整URL  带参数
        'url_with_query' => $request->fullUrl(),
        //  返回HTTP请求方式
        'method' => $request->method(),
        //  验证HTTP请求方式，是否匹配给定的字符串
        'isMethod' => $request->isMethod('post'),
        //  返回所有输入值
        'input' => $request->all(),
        //  判断参数在请求中是否存在(POST + GET)
        'isset' => $request->has('sex'),
        //  支持以数组形式查询多个参数，只有当参数都存在时，才会返回 true
        'issets' => $request->has(['name', 'email']),
        //  判断参数存在且参数值不为空
        'filled' => $request->filled('name'),
        //  访问 浏览器参数
//        'server' => $request->server(),
        //  header 头 数组
        'header' => $request->header(),
        //  header 头 指定参数是否存在
        'hasHeader' => $request->hasHeader('host'),
    );
    return $result;
});

//  文件上传
Route::get('index', 'UserController@index');
Route::post('form', 'UserController@login');
//  Cookie
Route::get('cookie/add', function () {
    $minutes = 2 * 60;
//    return response('学习 Laravel')->cookie('name', '哈喽', $minutes);
    $cookie = cookie('name', '上善若水', $minutes);
    return response('欢迎来到 幻想世界')->cookie($cookie);
});

Route::get('cookie/get', function (Request $request) {
    $cookie = $request->cookie('name');
    dd($cookie);
});


//  HTTP响应
Route::get('/', function () {
//    return 'hello world';
    return [1,2,3];
});

//Response 对象
Route::get('cookie/response', function () {
//    return response('Hello World',200)
//        ->header('Content-Type', 'application/json');
    //  添加响应头
//    return response('Hello Laravel')
//        ->header('Content-Type', 'text/html')
//        ->header('X-Header-One', 'Header Value1')
//        ->header('X-Header-Two', 'Header Value2');

    //  指定头信息组添加到响应中
    return response('Hello PHP')
        ->withHeaders([
           'Content-Type' => 'text/plain',
            'X-Header-X'  => 'header value',
            'X-header-Y'  => 'header value',
        ]);
});

//  添加Cookie 到响应
Route::get('cookie/setCookie', function () {
    //  使用 cookie() 生成Cookie 并将其添加到响应实例中
//    return response('set cookie')
//        ->header('Content-Type', 'text/plain')
//        //  ->cookie($name, $value, $minutes, $path, $domain, $secure, $httpOnly)
//        ->cookie('username','喝哈', 60);

    //  使用 Cookie 门面以 "队列"形式，将Cookie 添加到响应中
    \Illuminate\Support\Facades\Cookie::queue(Cookie::make('site', 'Laravel',1));
    \Illuminate\Support\Facades\Cookie::queue('author','Sun',1);
    return response('Hello', 200)
        ->header('Content-Type', 'text/plain');
});

//  重定向
Route::get('redirect', function () {
    //  通过命名路由，重定向到指定路由
    //   return redirect()->route('hey');
    //  通过 Eloquent 模型填充参数
//    return redirect()->route('test',1);
    //  重定向到控制器动作
    //  和 route 方法一样，如果控制器路由要求参数，你可以将参数作为第二个参数传递给 action 方法
    return redirect()->action('PostController@create',['id'=>1]);

});

//  带一次性 Session 数据的重定向
Route::post('user/profiles', function (Request $request) {
    $request->flush();
//    dd($request->all());
    return redirect('dashboard')->with('status','profile updated!');
});

//  下载文件
Route::get('download/response', function() {
    return response()->download(storage_path('app/photo/test.jpg'), '测试图片.jpg');
});

//  在浏览器显示文件，例如图片或 PDF，而不需要下载
Route::get('img', function () {
   return response()->file(storage_path('app/photo/test.jpg'));
});

//  视图响应
Route::get('view/response', function () {
    return response()
        ->view('hey',['website' => '视图响应'])
        ->header('Content-Type', 'text/html');
});


//  Json响应
Route::get('json/response', function (Request $request) {
   //   json 方法会自动将 Content-Type 头设置为 application/json，
    //  并使用 PHP 函数 json_encode 方法将给定数组转化为 JSON 格式数据
//    return response()->json([
//        'name' => 'Sun',
//       'status' => '200'
//   ]) ;

    //  Laravel 默认返回 json 数据
//    return array(
//        'name' => 'Sun',
//       'status' => '200'
//    );

    //  返回的还是字符串
//    return response('hello')
//        ->header('Content-Type', 'application/json');
    //  JSONP 跨域请求
//    return response()->json([
//        'name' => 'Sun',
//       'status' => '200'
//    ])->withCallback('www.baidu.com');
    return response()
        ->jsonp($request->input('callback'), ['name' => 'Abigail', 'state' => 'CA']);
});

//  响应宏
//  定义一个自定义的可以在多个路由和控制器中复用的响应
Route::get('macro/response', function () {
    return response()->caps('LaravelAcademy');
});

Route::get('blade', function () {
    return view('child',['name' => 'sun<br />']);
});


Route::get('greeting', function () {
//    //  可判断 视图是否存在
//    if (\Illuminate\Support\Facades\View::exists('greet'))
//        return view('greeting', ['name' => 'Laravel']);
//    else
//        return response('不存在','404');

    //  返回第一个存在的视图
//    return \Illuminate\Support\Facades\View::first(['greeting','child'],['name' => '返回数组中第一个存在的视图']);

    //  传递数据到视图
    //  方法一：
//    return view('greeting',['name'=>'嗯哼']);
    //  方法二：
//    return view('greeting')->with('name', 'World');
    return view('greeting')->with(['name' => 'Tom']);
});