<?php

namespace App\Providers;

use App\Model\Vadmin\Core\Thuonghieu\ActhIndex;
use App\Services\VinaEnter\VneSharingService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::share('publicUrl', getenv('PUBLIC_URL','/public/templates/core'));
        View::share('adminUrl', getenv('ADMIN_URL','/public/templates/admin'));
        
        

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


