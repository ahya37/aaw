<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class GlobalProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    public function __construct()
    {
        
    }

    public function decimalFormat($data) {
        $show = number_format((float)$data,0,',','.');
        return $show;
    }

    public function persen($data)
    {
        $show = number_format($data,1);
        return $show;
    }
}
