<?php

namespace TomatoPHP\TomatoRelationManager;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use TomatoPHP\TomatoRelationManager\Console\TomatoRelationManagerInstall;
use TomatoPHP\TomatoRelationManager\View\Components\RelationManager;


class TomatoRelationManagerServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //Register generate command
        $this->commands([
            TomatoRelationManagerInstall::class
       ]);

        $this->mergeConfigFrom(
            __DIR__.'/../config/tomato-relation-manager.php', 'tomato-relation-manager'
        );
        //Register views
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'tomato-relation-manager');

        //Publish Views
        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/tomato-sauce'),
        ], 'tomato-relation-manager-views');

        //Publish Components
        $this->publishes([
            __DIR__.'/View/Components' => app_path('View/Components/vendor/tomato-sauce'),
        ], 'tomato-relation-manager-components');

    }

    public function boot(): void
    {

        Blade::component('tomato-relation-manager', RelationManager::class);


    }
}
