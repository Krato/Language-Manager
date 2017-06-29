<?php

namespace EricLagarda\LangmanGUI;

use EricLagarda\LangmanGUI\Manager;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\ServiceProvider;

class LangmanServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/langmanGUI.php' => config_path('langmanGUI.php'),
        ], 'config');

        $this->publishes([
            __DIR__.'/../public' => public_path('vendor/langman'),
        ], 'assets');

        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/langmanGUI'),
        ], 'views');

        $this->loadViewsFrom(__DIR__.'/../resources/views', 'langmanGUI');

        $this->registerRoutes();
    }

    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/langmanGUI.php', 'langmanGUI');

        $this->app->singleton(Manager::class, function () {
            return new Manager(
                new Filesystem(),
                $this->app['path.lang'],
                [$this->app['path.resources'], $this->app['path']]
            );
        });
    }

    /**
     * Register the Langman routes.
     */
    protected function registerRoutes()
    {

        $routeName = config('langmanGUI.route_name');

        $this->app['router']->group(config('langmanGUI.route_group_config'), function ($router) use ($routeName) {
            $router->get('/'.$routeName, 'LangmanController@index');

            $router->post('/'.$routeName.'/scan', 'LangmanController@scan');

            $router->post('/'.$routeName.'/save', 'LangmanController@save');

            $router->post('/'.$routeName.'/delete', 'LangmanController@delete');

            $router->post('/'.$routeName.'/add-language', 'LangmanController@addLanguage');
        });
    }
}
