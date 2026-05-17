<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;

class AppServiceProvider extends ServiceProvider
{

    public function register(): void
    {
        //
    }


    public function boot(): void
    {
        view()->share('actual_url', asset('../assets/'));
        config(['app.actual_url' => asset('../assets/')]);

        view()->share('img_path', asset('../assets/uploads/'));
        config(['app.img_path' => asset('../assets/uploads/')]);
    }
}
