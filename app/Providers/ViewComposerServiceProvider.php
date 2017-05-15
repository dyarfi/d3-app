<?php namespace App\Providers;

use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;

class ViewComposerServiceProvider extends ServiceProvider {

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function boot(Request $request) {

		$this->changeLocaleUrl($request);
		
	}

	public function register() {}

	protected function changeLocaleUrl(Request $request) {

		// Set segment variable
		$segments = $request->segments();		
		// Load config app
		$app = app('config')->get('app.locales');
		// Check if segment existed in language array
		if($segments && in_array($segments[0], array_keys($app))) {

			// Unset first uri segment
			unset($segments[0]);

			// Implode the uri segment
			$implode = implode('/', array_map('urldecode', $segments));	
			
			// Set to the url
			$url = '%s/' . $implode;

		} else {

			// Implode the uri segment
			$implode = implode('/', array_map('urldecode', $segments));	

			// Set to the url to default
			$url = '%s/'.$implode;	

		}

		// Give siteLocale variable to all views.
		view()->share('changeLocaleUrl', $url);
		
	}

}
