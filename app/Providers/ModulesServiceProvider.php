<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\RouteCollection as RouteCollection;
use Illuminate\Routing\Route;
/**
* ServiceProvider
*
* The service provider for the modules. After being registered
* it will make sure that each of the modules are properly loaded
* i.e. with their routes, views etc.
*
* @author Kamran Ahmed <kamranahmed.se@gmail.com>
* @package App\Modules
*/
class ModulesServiceProvider extends ServiceProvider
{

    /**
     * This namespace is applied to the controller routes in your routes file.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Modules';

    /**
     * Will make sure that the required modules have been fully loaded
     * @return void
     */
    public function boot()
    {
        
        // For each of the registered modules, include their routes and Views        
        $modules = config('setting.modules');
        // Loop modules to load
        while (list($module, $dir) = each($modules)) {
            // Load key variable to string
            $key = key($dir);            
            // Load the routes for each of the modules
            if(file_exists(app_path('/Modules/'.$key.'/routes.php'))) {
                include app_path('/Modules/'.$key.'/routes.php');
            }
            // Load the views
            if(is_dir(app_path('/Modules/'.$key.'/Views'))) {
                // The package views have been published - use those views.
                $this->loadViewsFrom(app_path('/Modules/'.$key.'/Views'), $key);
            }
            // Flagged User Module if Admin String existed
            if($key === 'Admin' 
                && file_exists(app_path('/Modules/User/routes.php')) 
                    && is_dir(app_path('/Modules/User/Views'))) {
                // Include User Module Directory
                include app_path('/Modules/User/routes.php');     
                // The package views have been published - use those views.
                $this->loadViewsFrom(app_path('/Modules/User/Views'), 'User');  
            }

        }

    }

    /**
     * Register the services provided by the provider.
     *
     * @return array
     */
    public function register() { }

}
