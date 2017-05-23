<?php namespace App\Http\Controllers;

// Load Laravel classes
use Request;

// Load main models
use App\Modules\Page\Model\Menu, App\Modules\Page\Model\Page;

class PortfolioController extends BasePublic {


	//public $restful = true;

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		// Parent constructor
		parent::__construct();

		//$this->middleware('auth');

		//$this->middleware('language');

		//dd(Auth::inRole('admin'));
	}

	public function home()
	{
		return $this->view('pages.home')->title('Home - Laravel Tasks');
	}
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		// Get the page path that requested
		$path = pathinfo(Request::path(), PATHINFO_BASENAME);

		// Set data to return
		$data = ['menu'=>$this->menu->where('slug', $path)->first()];

		return $this->view('menus.portfolio')->data($data)->title('Page | Portfolio');
		//
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}
