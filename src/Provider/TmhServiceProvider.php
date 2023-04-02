<?php
   
namespace amk\tmh\provider;

use Illuminate\Support\ServiceProvider;
use Amk\Tmh\TMH;

class TmhServiceProvider extends ServiceProvider {
        
        /**
         * [Description for boot]
         *
         * @return [type]
         * 
         */
        
        public function boot()
        {
            if ($this->app->runningInConsole()) {
                $this->publishes([
                    __DIR__.'/../config/tmh.php' => config_path('tmh.php')
                ], 'tmh-config');

                $this->publishes([
                    __DIR__.'/../lang' => resource_path('lang/vendor/tmh')
                ], 'tmh-translation');
            }
                
            $this->loadTranslationsFrom(__DIR__.'/../lang', 'tmh');


        }
        
        /**
         * [Description for register]
         *
         * @return [type]
         * 
         */

        public function register()
        {
            $this->app->bind(TMH::class, function ($app) {
                return new TMH();
            });
        }
   }
?>