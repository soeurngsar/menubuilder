<?php

namespace SoeurngSar\MenuBuilder;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Routing\Router;

class MenuServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {

        $this->publishes([
            __DIR__.'/config/menu.php'  => config_path('menu.php'),
        ], 'config');

        $this->publishes([
           __DIR__.'/resources/views'   => resource_path('views/vendor'),
        ], 'view');

         $this->publishes([
            __DIR__.'/public/menubuilder' => public_path('vendor/menubuilder'),
        ], 'public');

        $this->publishes([
            __DIR__.'/database/migrations/2017_08_11_073824_create_menus_table.php' => database_path('migrations/2017_08_11_073824_create_menus_table.php'),
            __DIR__.'/database/migrations/2017_08_11_074006_create_menu_items_table.php' => database_path('migrations/2017_08_11_074006_create_menu_items_table.php'),
        ], 'migrations');

    }

    public function setupRoutes(Router $router)
    {
        $router->group(['namespace' => 'SoeurngSar\MenuBuilder\app\Http\Controllers'], function ($router) {
            require  __DIR__.'/routes/routes.php';
        });
    }
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->setupRoutes($this->app->router);
        $this->app->bind('menubuilder', function() {
            return new WMenu();
        });

        $this->app->make('SoeurngSar\MenuBuilder\app\Http\Controllers\MenuController');
        $this->loadViewsFrom(__DIR__.'/resources/views/menubuilder', 'wmenu');

    }
}
