<?php namespace App\Http\Controllers;

use Mail;
// Load modules
use App\Modules\Banner\Model\Banner;
use App\Modules\Portfolio\Model\Portfolio;
use App\Modules\Portfolio\Model\Client;
use App\Modules\Blog\Model\Blog;

class HomeController extends BasePublic  {


	/*
	|--------------------------------------------------------------------------
	| Home Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders your application's "homepage" for users that
	| are authenticated. Of course, you are free to change or remove the
	| controller as you wish. It is just here to get your app started!
	|
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct() {
		parent::__construct();

		// Env
		// print_r(env('APP_ENV'));

	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function index()
	{

		$data = [
			'banners'=>Banner::where('status',1)->orderBy('created_at')->take(4)->get(),
			'blogs'=>Blog::active()->orderBy('created_at')->take(4)->get(),
			'clients'=>Client::active()->orderBy('created_at')->take(24)->get(),
		];

		return $this->view('home')->data($data)->title('Home'); //- See more at: http://laravelsnippets.com/snippets/base-controller-extended#sthash.qTHFuvbZ.dpuf

	}

}
