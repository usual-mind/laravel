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

    public function store(Request $request, $id)
    {

        $name = $request->input('name');
        return view('user.profile', ['user' => $name]);
    }
}
