<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class ShowProfile extends Controller
{
    //在PHP中，当尝试以调用函数的方式调用一个对象时，__invoke()方法会被自动调用
    /**
     * 展示给定用户的个人主页
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author   usual_mind
     */
    public function __invoke($id)
    {
        // TODO: Implement __invoke() method.
        return view('user.profile', ['user' => User::findOrFail($id)]);
    }
}
