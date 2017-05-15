<?php namespace App\Http\Middleware;

use Closure;
use Illuminate\Routing\Redirector;
use Illuminate\Http\Request;
use Illuminate\Foundation\Application;
use Illuminate\Contracts\Routing\Middleware;

class Language implements Middleware {
	
	/**
	 * The Router implementation.
	 *
	 * @var Router
	 */
	protected $router;

	public function __construct(Application $app, Redirector $redirector, Request $request) {
		$this->app = $app;
		$this->redirector = $redirector;
		$this->request = $request;
		$this->fallback_locale = $this->app->config->get('app.locales');
		$this->default_locale  = $this->app->config->get('app.locale');
	}

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		
		$locale = $request->segment(1);

		if ( array_key_exists($locale, $this->fallback_locale)) {
			
			$this->app->setLocale($locale);
					
		} 

		return $next($request);
	}

}
