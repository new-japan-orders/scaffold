<?php

namespace NewJapanOrders\Scaffold;

use Illuminate\Support\ServiceProvider as Provider;

class ServiceProvider extends Provider {

    /** 
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {   
        //  

    }   

    /** 
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {   

        $this->registerCommand();

    }   


    /** 
     * Register the make:scaffold generator.
     */
    private function registerCommand()
    {   
        $this->app->singleton('command.nwo.scaffold.app', function ($app) {
            return $app['NewJapanOrders\Scaffold\Commands\ScaffoldAppCommand'];
        }); 
        $this->commands('command.nwo.scaffold.app');

        $this->app->singleton('command.nwo.scaffold.auth', function ($app) {
            return $app['NewJapanOrders\Scaffold\Commands\ScaffoldAuthCommand'];
        }); 
        $this->commands('command.nwo.scaffold.auth');

        $this->app->singleton('command.nwo.scaffold.init', function ($app) {
            return $app['NewJapanOrders\Scaffold\Commands\ScaffoldInitCommand'];
        }); 
        $this->commands('command.nwo.scaffold.init');

        $this->app->singleton('command.nwo.scaffold.controller', function ($app) {
            return $app['NewJapanOrders\Scaffold\Commands\ScaffoldControllerCommand'];
        }); 
        $this->commands('command.nwo.scaffold.controller');

        $this->app->singleton('command.nwo.scaffold.model', function ($app) {
            return $app['NewJapanOrders\Scaffold\Commands\ScaffoldModelCommand'];
        }); 
        $this->commands('command.nwo.scaffold.model');

        $this->app->singleton('command.nwo.scaffold.view', function ($app) {
            return $app['NewJapanOrders\Scaffold\Commands\ScaffoldViewCommand'];
        }); 
        $this->commands('command.nwo.scaffold.view');

        $this->app->singleton('command.nwo.scaffold.mvc', function ($app) {
            return $app['NewJapanOrders\Scaffold\Commands\ScaffoldMVCCommand'];
        }); 
        $this->commands('command.nwo.scaffold.mvc');

        $this->app->singleton('command.nwo.scaffold.policy', function ($app) {
            return $app['NewJapanOrders\Scaffold\Commands\ScaffoldPolicyCommand'];
        }); 
        $this->commands('command.nwo.scaffold.policy');


    }
}
