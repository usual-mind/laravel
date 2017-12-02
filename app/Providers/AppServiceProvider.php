<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        //  排除 1071错误，因为数据库版本不支持utf8mb4 字符串长度，所以需要限制
        Schema::defaultStringLength(191);

        //  修改默认资源路由访问的链接(只修改链接，默认访问的控制器方法名不变)
        Route::resourceVerbs([
            'create' => 'add',
            'edit'   => 'gai',
        ]);

        //  在视图间共享数据
        View::share('key','value');

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
