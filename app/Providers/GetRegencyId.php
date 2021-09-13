<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class GetRegencyId extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public $regency_id;
    
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

    public function __construct($regency_id)
    {
        $this->regency_id = $regency_id;
    }

    public function regencyId()
    {
        // ini berfungsi untuk mengirimkan regency_id ke controller API\DashboardController
        return $this->regency_id;
    }
}
