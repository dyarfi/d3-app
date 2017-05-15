<?php namespace App\Providers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Routing\Router;

class RouteServiceProvider extends ServiceProvider {

	/**
	 * This namespace is applied to the controller routes in your routes file.
	 *
	 * In addition, it is set as the URL generator's root namespace.
	 *
	 * @var string
	 */
	protected $namespace = 'App\Http\Controllers';

	/**
	 * Define your route model bindings, pattern filters, etc.
	 *
	 * @param  \Illuminate\Routing\Router  $router
	 * @return void
	 */
	public function boot(Router $router)
	{
		parent::boot($router);
	}

	/**
	 * Define the routes for the application.
	 *
	 * @return void
	 */
	public function map(Router $router, Request $request)
	{
		
		$locale = $request->segment(1);
		
		$routes = ['namespace' => $this->namespace];

		if ( array_key_exists($locale, $this->app->config->get('app.locales'))) {
			
			$routes = array_merge($routes, ['prefix' => $locale]);

		} else {

			$default = $this->app->config->get('app.locale');
			
			$locale = $default;

		}

		$this->app->setLocale($locale);
		
		$router->group($routes, function($router) {
			require app_path('Http/routes.php');
		});
	}


}
