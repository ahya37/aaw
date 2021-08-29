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

    public function cutStringCardRegency($data)
    {
        $show = substr($data, 2);
        return $show;
    }

    public function cutStringCardDistrict($data)
    {
        $show = substr($data, 4);
        return $show;
    }

    public function cutStringCardVillage($data)
    {
        $show = substr($data, 6);
        return $show;
    }
}
