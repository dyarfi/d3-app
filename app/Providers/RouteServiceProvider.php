<?php namespace App\Providers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
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
	public function boot()
	{
		parent::boot();
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
			require base_path('routes/web.php');
		});
		
		$this->mapApiRoutes();

        $this->mapWebRoutes();



		 //Route::middleware('web')
             //->namespace($this->namespace)
             //->group(base_path('routes/web.php'));

//dd($router);

		//Route::middleware('web')
             //->namespace($this->namespace)
             //->group($routes, function($router) {
             	//require base_path('routes/web.php');
         //});

		// This is supposed to be the main default for all menu pages in the Apps
		/*
		if (! app()->runningInConsole()) {
            foreach (Menu::all() as $menu) {
                $router->get($menu->uri, ['as' => $menu->name, function () use ($menu, $router) {
                    return $this->app->call('SundaySim\Http\Controllers\PageController@show', [
                        'page' => $menu,
                        'parameters' => $router->current()->parameters()
                    ]);
                }]);
            }
        }
		*/
	}

 	/**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
             ->namespace($this->namespace)
             ->group(base_path('routes/web.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
             ->middleware('api')
             ->namespace($this->namespace)
             ->group(base_path('routes/api.php'));
    }


}
