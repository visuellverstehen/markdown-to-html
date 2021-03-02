<?php

namespace VV\Markdown;

use Statamic\Providers\AddonServiceProvider;

class ServiceProvider extends AddonServiceProvider
{
    public function register()
    {
        parent::register();
    }

    public function boot()
    {
        parent::boot();

//        $this->mergeConfigFrom(__DIR__ . '/../config/config.php', 'classify');
//
//        if ($this->app->runningInConsole()) {
//            $this->publishes([
//                __DIR__ . '/../config/config.php' => config_path('classify.php'),
//            ], 'classify');
//        }
    }
}
