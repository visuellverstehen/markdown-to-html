<?php

namespace VV\Markdown;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use VV\Markdown\Markdown\CommonMarkRepository;
use VV\Markdown\Markdown\MarkdownRepository;

class ServiceProvider extends BaseServiceProvider
{
    public function register()
    {
        $this->app->singleton(MarkdownRepository::class, function () {
            return new CommonMarkRepository(config('markdown.settings.commonmark'));
        });
    }

    public function boot()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/config.php', 'markdown');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/config.php' => config_path('markdown.php'),
            ], 'markdown');
        }
    }
}
