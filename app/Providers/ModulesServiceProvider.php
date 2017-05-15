<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;
 
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
        $modules = config('module.modules');

        while (list($module, $dir) = each($modules)) {            

            // Load the routes for each of the modules
            if(file_exists(app_path('/Modules/'.$module.'/routes.php'))) {
                // include __DIR__.'/'.$module.'/routes.php';
                include app_path('/Modules/'.$module.'/routes.php');
            }            

            // Load the views
            if(is_dir(app_path('/Modules/'.$module.'/Views'))) {
                // $this->loadViewsFrom(__DIR__.'/'.$module.'/Views', $module);
                $this->loadViewsFrom(app_path('/Modules/'.$module.'/Views'), $module);
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