<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ConstantsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        // Load constants configuration
        $constants = config('constants');

        // Share constants with all views
        view()->share('constants', $constants);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
?>