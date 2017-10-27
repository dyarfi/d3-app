<?php namespace App\Http\Controllers;

// Load Laravel classes
use Request;

// Load main models
use App\Modules\Page\Model\Menu, App\Modules\Page\Model\Page, App\Modules\Portfolio\Model\Portfolio;

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
		$data = ['menu'=>$this->menu->where('slug', $path)->first(),'portfolios'=>Portfolio::active()->with('client')->with('project')->with('tags')->orderBy('index','ASC')->paginate(1)];

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
	 * @param  string $slug
	 * @return Response
	 */
	public function show($slug)
	{

		// Get data from database
        $portfolio = Portfolio::where('slug',$slug)->with('client')->with('media')->first();
	   	$data = ['portfolio'=>$portfolio,'portfolios'=>Portfolio::where('id','!=',$portfolio->id)->with('client')->with('tags')->get()];

	   	// Return data and view
	   	return $this->view('portfolio.show')->data($data)->title('View Portfolio - Portfolios');

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
