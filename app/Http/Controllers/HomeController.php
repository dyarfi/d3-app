<?php namespace App\Http\Controllers;

class HomeController extends BasePublic  {


	/*
	|--------------------------------------------------------------------------
	| Home Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders your application's "dashboard" for users that
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

	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
		
		//echo trans('passwords.reset');
		// Set data to return
	   	//$data = ['menus'=>$this->menu->all()];
		$data = [];

		return $this->view('home')->data($data)->title('Home'); //- See more at: http://laravelsnippets.com/snippets/base-controller-extended#sthash.qTHFuvbZ.dpuf
		
	}

}
