<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class VNEProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //for core
        require_once app_path().'/Helpers/Core/CoreHelper.php';
        require_once app_path().'/Helpers/Core/CoreMultiLevelHelper.php';

        //for tmp
        require_once app_path().'/Helpers/TmpVinaEnter/VneHelper.php';
        require_once app_path().'/Helpers/TmpVinaEnter/TmpHelper.php';

    
    }
}
