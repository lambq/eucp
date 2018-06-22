<?php

namespace Lambq\Eucp;

use Illuminate\Support\ServiceProvider;

class EucpProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/config/eucp.php' => config_path('eucp.php'),
        ]);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->app->singleton('eucp', function (){
            return new eucp();
        });
    }
}
