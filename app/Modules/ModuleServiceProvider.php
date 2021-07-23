<?php


namespace App\Modules;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
class ModuleServiceProvider extends ServiceProvider
{
    /**
     * Register config file here
     * alias => path
     */


    /**
     * Register bindings in the container.
     */
    public function register()
    {

    }

    /**
     * Perform post-registration booting of services.
     */

    public function boot(){
            //boot routes
            $modules = array_map('basename', \File::directories(__DIR__));
            foreach ($modules as $module) {
                if(file_exists(__DIR__.'/'.$module.'/routes.php')) {
                    include __DIR__.'/'.$module.'/routes.php';
                }
            //boot views
            $view_path = __DIR__.'/'.$module.'/Views';
            if(is_dir($view_path)) {
                $this->loadViewsFrom($view_path, $module);
            }
            // boot migration
            if (file_exists(__DIR__.'/'.$module . "/databases/migrations")) {
                $this->loadMigrationsFrom(__DIR__.'/'.$module . "/databases/migrations");
            }
        }

    }


}