<?php

return [

	/*
	|--------------------------------------------------------------------------
	| Application Debug Mode
	|--------------------------------------------------------------------------
	|
	| When your application is in debug mode, detailed error messages with
	| stack traces will be shown on every error that occurs within your
	| application. If disabled, a simple generic error page is shown.
	|
	*/

	'debug' => env('APP_DEBUG',true),

	/*
	|--------------------------------------------------------------------------
	| Application URL
	|--------------------------------------------------------------------------
	|
	| This URL is used by the console to properly generate URLs when using
	| the Artisan command line tool. You should set this to the root of
	| your application so that it is used when running Artisan tasks.
	|
	*/

	'url' => 'http://localhost/d3-app/',

	/*
	|--------------------------------------------------------------------------
	| Application Timezone
	|--------------------------------------------------------------------------
	|
	| Here you may specify the default timezone for your application, which
	| will be used by the PHP date and date-time functions. We have gone
	| ahead and set this to a sensible default for you out of the box.
	|
	*/

	//'timezone' => 'UTC',
	'timezone' => 'Asia/Jakarta',

	/*
	|--------------------------------------------------------------------------
	| Application Locale Configuration
	|--------------------------------------------------------------------------
	|
	| The application locale determines the default locale that will be used
	| by the translation service provider. You are free to set this value
	| to any of the locales which will be supported by the application.
	|
	*/

	'locale' => 'en',
	'locales' => ['en' => 'English','id' => 'Indonesia','in' => 'India'],

	/*
	|--------------------------------------------------------------------------
	| Application Fallback Locale
	|--------------------------------------------------------------------------
	|
	| The fallback locale determines the locale to use when the current one
	| is not available. You may change the value to correspond to any of
	| the language folders that are provided through your application.
	|
	*/

	'fallback_locale' => 'en',

	/*
	|--------------------------------------------------------------------------
	| Encryption Key
	|--------------------------------------------------------------------------
	|
	| This key is used by the Illuminate encrypter service and should be set
	| to a random, 32 character string, otherwise these encrypted strings
	| will not be safe. Please do this before deploying an application!
	|
	*/

	'key' => env('APP_KEY', 'RandStringLaravelApanel'),
	'cipher' => MCRYPT_RIJNDAEL_128,

	/*
	|--------------------------------------------------------------------------
	| Logging Configuration
	|--------------------------------------------------------------------------
	|
	| Here you may configure the log settings for your application. Out of
	| the box, Laravel uses the Monolog PHP logging library. This gives
	| you a variety of powerful log handlers / formatters to utilize.
	|
	| Available Settings: "single", "daily", "syslog", "errorlog"
	|
	*/

	'log' => 'daily',

	/*
	|--------------------------------------------------------------------------
	| Autoloaded Service Providers
	|--------------------------------------------------------------------------
	|
	| The service providers listed here will be automatically loaded on the
	| request to your application. Feel free to add your own services to
	| this array to grant expanded functionality to your applications.
	|
	*/

	'providers' => [

		/*
         * Laravel Framework Service Providers...
         */
        Illuminate\Foundation\Providers\ArtisanServiceProvider::class,
        Illuminate\Auth\AuthServiceProvider::class,
        Illuminate\Broadcasting\BroadcastServiceProvider::class,
        Illuminate\Bus\BusServiceProvider::class,
        Illuminate\Cache\CacheServiceProvider::class,
        Illuminate\Foundation\Providers\ConsoleSupportServiceProvider::class,
        Illuminate\Routing\ControllerServiceProvider::class,
        Illuminate\Cookie\CookieServiceProvider::class,
        Illuminate\Database\DatabaseServiceProvider::class,
        Illuminate\Encryption\EncryptionServiceProvider::class,
        Illuminate\Filesystem\FilesystemServiceProvider::class,
        Illuminate\Foundation\Providers\FoundationServiceProvider::class,
        Illuminate\Hashing\HashServiceProvider::class,
        Illuminate\Mail\MailServiceProvider::class,
        Illuminate\Pagination\PaginationServiceProvider::class,
        Illuminate\Pipeline\PipelineServiceProvider::class,
        Illuminate\Queue\QueueServiceProvider::class,
        Illuminate\Redis\RedisServiceProvider::class,
        Illuminate\Auth\Passwords\PasswordResetServiceProvider::class,
        Illuminate\Session\SessionServiceProvider::class,
        Illuminate\Translation\TranslationServiceProvider::class,
        Illuminate\Validation\ValidationServiceProvider::class,
        Illuminate\View\ViewServiceProvider::class,
		Collective\Html\HtmlServiceProvider::class,
		Intervention\Image\ImageServiceProvider::class,
		/*
		 * Application Service Providers...
		 */
		App\Providers\AppServiceProvider::class,
		App\Providers\BusServiceProvider::class,
		App\Providers\ConfigServiceProvider::class,
		App\Providers\EventServiceProvider::class,
		App\Providers\RouteServiceProvider::class,

		/*
		 * Modular Class Service Provider
		 */
		App\Providers\ModulesServiceProvider::class,

		/*
		 * Laravel Localization View Composer Provider
		 */
		App\Providers\ViewComposerServiceProvider::class,

		/*
		 * Laravel Socialite Class
		 */
		Laravel\Socialite\SocialiteServiceProvider::class,

		/*
		 * Cartalyst https://cartalyst.com/manual/sentinel/2.0 - Sentinel user groups permission
		 */
		Cartalyst\Sentinel\Laravel\SentinelServiceProvider::class,

		/*
		 * Cartalyst https://cartalyst.com/manual/tags/2.0#laravel - A Tagging package that easily allows you to add tags to your Eloquent models.
		 */
		Cartalyst\Tags\TagsServiceProvider::class,

		/*
		 * http://www.maatwebsite.nl/laravel-excel/docs/getting-started#installation
		 */
		Maatwebsite\Excel\ExcelServiceProvider::class,

		/*
		 * https://github.com/anhskohbo/no-captcha
		 */
		Anhskohbo\NoCaptcha\NoCaptchaServiceProvider::class,

		/*
		 * https://datatables.yajrabox.com/starter
		 */
		Yajra\Datatables\DatatablesServiceProvider::class,

		/*
		 * https://github.com/plank/laravel-mediable
		 */
		Plank\Mediable\MediableServiceProvider::class,


		/*
		 * https://github.com/mpociot/teamwork
		 */
		Mpociot\Teamwork\TeamworkServiceProvider::class
	],

	/*
	|--------------------------------------------------------------------------
	| Class Aliases
	|--------------------------------------------------------------------------
	|
	| This array of class aliases will be registered when this application
	| is started. However, feel free to register as many as you wish as
	| the aliases are "lazy" loaded so they don't hinder performance.
	|
	*/

	'aliases' => [

		'App'       => Illuminate\Support\Facades\App::class,
        'Artisan'   => Illuminate\Support\Facades\Artisan::class,
		// ------- Original Laravel Auth Class - start --------------
        'Auth'      => Illuminate\Support\Facades\Auth::class,
		// ------- Original Laravel Auth Class - end ----------------
        'Blade'     => Illuminate\Support\Facades\Blade::class,
        'Bus'       => Illuminate\Support\Facades\Bus::class,
        'Cache'     => Illuminate\Support\Facades\Cache::class,
		// ------- Original Laravel Config Class - end ----------------
        //'Config'    => Illuminate\Support\Facades\Config::class,
		// ------- Save changes to the configuration file in script. | https://github.com/larapack/config-writer ----------
		'Config' 	=> Larapack\ConfigWriter\Facade::class,
		'ConfigWriter' => Larapack\ConfigWriter\Repository::class,
        'Cookie'    => Illuminate\Support\Facades\Cookie::class,
        'Crypt'     => Illuminate\Support\Facades\Crypt::class,
        'DB'        => Illuminate\Support\Facades\DB::class,
        'Eloquent'  => Illuminate\Database\Eloquent\Model::class,
        'Event'     => Illuminate\Support\Facades\Event::class,
        'File'      => Illuminate\Support\Facades\File::class,
        'Gate'      => Illuminate\Support\Facades\Gate::class,
        'Hash'      => Illuminate\Support\Facades\Hash::class,
        'Input'     => Illuminate\Support\Facades\Input::class,
        'Lang'      => Illuminate\Support\Facades\Lang::class,
        'Log'       => Illuminate\Support\Facades\Log::class,
        'Mail'      => Illuminate\Support\Facades\Mail::class,
        'Password'  => Illuminate\Support\Facades\Password::class,
        'Queue'     => Illuminate\Support\Facades\Queue::class,
        'Redirect'  => Illuminate\Support\Facades\Redirect::class,
        'Redis'     => Illuminate\Support\Facades\Redis::class,
        'Request'   => Illuminate\Support\Facades\Request::class,
        'Response'  => Illuminate\Support\Facades\Response::class,
        'Route'     => Illuminate\Support\Facades\Route::class,
        'Schema'    => Illuminate\Support\Facades\Schema::class,
        'Session'   => Illuminate\Support\Facades\Session::class,
        'Storage'   => Illuminate\Support\Facades\Storage::class,
        'URL'       => Illuminate\Support\Facades\URL::class,
        'Validator' => Illuminate\Support\Facades\Validator::class,
        'View'      => Illuminate\Support\Facades\View::class,

		'Str'       => Illuminate\Support\Str::class,
		'Form' 		=> Collective\Html\FormFacade::class,
      	'Html' 		=> Collective\Html\HtmlFacade::class,
      	'Image' 	=> Intervention\Image\Facades\Image::class,
		// Laravel Socialite for social signin
		'Socialite' => Laravel\Socialite\Facades\Socialite::class,

		// ------- Sentinel Auth Class - start --------------

		// Sentinel user groups permission
		'Activation'      => Cartalyst\Sentinel\Laravel\Facades\Activation::class,
		// Unmark this if you want to overide the Original Laravel Auth Class with Sentinel
		//'Auth'          => 'Cartalyst\Sentinel\Laravel\Facades\Sentinel',
		'Reminder'        => Cartalyst\Sentinel\Laravel\Facades\Reminder::class,
		// Sentinel Auth for administrator page
		'Sentinel'        => Cartalyst\Sentinel\Laravel\Facades\Sentinel::class,
		// ------- Sentinel Auth Class - end ----------------

		// Simple PHP API extension for DateTime. [http://carbon.nesbot.com](http://carbon.nesbot.com)
		'Carbon'		=> Carbon\Carbon::class,
		// An eloquent way of importing and exporting Excel and CSV files
		'Excel' 		=> Maatwebsite\Excel\Facades\Excel::class,

		// Modular service provider
		//'Modules'		=> Modules\ModulesServiceProvider::class,

		// Datatables jquery
		'Datatables' => Yajra\Datatables\Facades\Datatables::class,

		// Attach MediaUploader in models
		'MediaUploader' => Plank\Mediable\MediaUploaderFacade::class,

	],

];
