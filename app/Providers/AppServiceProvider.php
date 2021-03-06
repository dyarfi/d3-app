<?php namespace App\Providers;

// Load Service Provider Support
use Illuminate\Support\ServiceProvider;
// Load App Setting Model
use App\Modules\User\Model\Setting;

class AppServiceProvider extends ServiceProvider {

	/**
	 * Bootstrap any application services.
	 *
	 * @return void
	 */
	public function boot()
	{
		// Load from setting from DB
		$dbset = new Setting;

		// Load config/setting.php file
		$setting = config('setting');

		// Share a var with all views : $admin_url
		view()->share('admin_url', $setting['admin_url']);

		// Share a var with all views : $admin_app
		view()->share('admin_app', $dbset->slug('site-name') !='' ? $dbset->slug('site-name')->value : $setting['admin_app']);

		// Share a var with all views : $admin_url
		view()->share('company_name', $dbset->slug('company-name') !='' ? $dbset->slug('company-name')->value : $setting['company_name']);

		// Returning the current class name and action
		app('view')->composer('Admin::layouts.template', function($view)
	    {
	    	// $basename =  explode("@", str_replace('Controller','',class_basename(Route::getCurrentRoute()->getActionName())));
	        // $action = app('request')->route()->getAction();
			$action = app('request')->route()->getActionName();

	        // $controller = class_basename($action['controller']);
			$controller = class_basename($action);

			if (str_contains($controller, 'Controller@')) {

	        	list($controller, $action) = explode('Controller@', $controller);

	    	} else {

				list($controller, $action) = explode('@', $controller);

	    	}

        	$view->with(compact('controller', 'action'));

	    });
	    
	}

	/**
	 * Register any application services.
	 *
	 * This service provider is a great spot to register your various container
	 * bindings with the application. As you can see, we are registering our
	 * "Registrar" implementation here. You can add your own bindings too!
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app->bind(
			'Illuminate\Contracts\Auth\Registrar',
			'App\Services\Registrar'
		);
	}

}
