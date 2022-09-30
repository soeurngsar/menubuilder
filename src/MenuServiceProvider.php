<?php

namespace SoeurngSar\MenuBuilder;

use Illuminate\Support\ServiceProvider;

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

        /*
        $this->publishes([
           __DIR__.'/resources/views'   => resource_path('views/vendor'),
        ], 'view');
        */

         $this->publishes([
            __DIR__.'/public/menubuilder' => public_path('vendor/menubuilder'),
        ], 'public');

         /*
        $this->publishes([
            __DIR__.'/database/migrations/2017_08_11_073824_create_menus_table.php' => database_path('migrations/2017_08_11_073824_create_menus_table.php'),
            __DIR__.'/database/migrations/2017_08_11_074006_create_menu_items_table.php' => database_path('migrations/2017_08_11_074006_create_menu_items_table.php'),
        ], 'migrations');
         */
    }

    public function setup()
    {
        $configPath = file_exists(config_path('vendor/menu.php')) ? config_path('vendor/menu.php') : __DIR__.'/config/menu.php';
        $this->mergeConfigFrom($configPath, 'menu');
        $this->loadRoutesFrom( __DIR__.'/routes/routes.php');
        $this->loadTranslationsFrom(__DIR__.'/resources/lang', 'wmenu');
        $migrationPaths = [
            __DIR__.'/database/migrations/2017_08_11_073824_create_menus_table.php',
            __DIR__.'/database/migrations/2017_08_11_074006_create_menu_items_table.php',
        ];
        $this->loadMigrationsFrom($migrationPaths);
        $this->loadViewsFrom(__DIR__.'/resources/views/menubuilder', 'wmenu');
    }

    /**
     * @return void
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function register()
    {
        $this->setup();
        $this->app->bind('menubuilder', function() {
            return new WMenu();
        });
        $this->app->make('SoeurngSar\MenuBuilder\app\Http\Controllers\MenuController');
    }
}
