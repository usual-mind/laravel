<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UserController extends Controller
{
    /**
     * 调用方法前，需要先通过中间件验证
     * UserController constructor.
     */
    public function __construct()
    {
        //  指定中间件对所有方法生效
//        $this->middleware('token');
        //  指定中间件对指定方法生效    (也可以为数组  ['show', 'index'])
//        $this->middleware('token')->only('show');
        //  指定中间件，对指定方法以外的方法生效  (也可以为数组  ['show', 'index'])
//        $this->middleware('token')->except('show');
//        //  使用闭包注册中间件
//        $this->middleware(function ($request, $next) {
//            //  判断参数 id 是否为数字，否，抛出 404
//            if (!is_numeric($request->input('id'))) {
//                throw new NotFoundHttpException();
//            }
//            return $next($request);
//        });
    }

    /**
     * 为指定用户显示详情
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author   usual_mind
     */
    public function show($id)
    {
        return view('user.profile', ['user' => User::findOrFail($id)]);
    }

    public function test()
    {
        return view('user.profile', ['user' => '没有通过中间件']);
    }

    public function store(Request $request)
    {

        $name = $request->input('name');
        return view('user.profile', ['user' => $name]);
    }

    public function edit(User $user)
    {
        return $user;
    }

    public function index()
    {
        return view('user.index');
    }

    public function login(Request $request)
    {
//        $username = $request->input('username');
//        $password = $request->input('password');
//        if ($username != 'admin' || $password != '1234')
//            return redirect('index')->withInput($request->except('password'));
//        return '登陆成功';
        //  $request->file('name') <=> $request->name
        //  !!!!注意，使用hasFile() 表单需要添加一个属性 enctype="multipart/form-data"
        //  $request->hasFile('name')     判断文件在请求中是否存在
        //  $request->file('name')->isValid()   判断文件在上传过程中是否出错
        //  $request->photo->path();        路径
        //  $request->photo->extension();   拓展名
        $file1 = $request->file('photo');
        $file2 = $request->photo;
//        return array($file1,$file2);
        if ($request->hasFile('photo') && $request->file('photo')->isValid()) {
            $photo = $request->file('photo');
            $extension = $photo->extension();
//            $store_result = $photo->store('photo');
            $store_result = $photo->storeAs('photo', 'test.jpg','public');
            $path = $photo->path();

            $output = [
                'extension' => $extension,
                'store_result' => $store_result,
                'path' => $path,
            ];
            print_r($output);
            exit();
        }
        exit('未获取到上传文件或者上传过程出错');

    }
}
