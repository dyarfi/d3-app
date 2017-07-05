<?php namespace App\Http\Controllers;

// Load Laravel classes
use Request, DB;

// Load datetime helper
use Carbon\Carbon;

// Load main models
use App\Modules\Page\Model\Menu, App\Modules\Page\Model\Page;

// Load models
use App\Modules\Blog\Model\Blog;

class BlogController extends BasePublic {


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

		// Get active blogs with paginated
		$blogs = Blog::active()->with('category')->with('tags')->orderBy('index','ASC')->paginate(10);

		// Set data to return
	   	$data = ['menu'=>$this->menu->where('slug', $path)->first(),'blogs'=>$blogs];

		// Return view
		return $this->view('menus.blog')->data($data)->title('Page | Blog');

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
	 * Display the specified blogresource.
	 *
	 * @param  string $slug
	 * @return Response
	 */
	public function show($slug)
	{

		// Get data from database
        $blog = Blog::where('slug',$slug)->with('category')->with('tags')->first();

		// Get data list from database
		$blogs = Blog::active()->with('category')->with('tags')->orderBy('publish_date','ASC')->get();

		// Set data to view
		$data = ['blog'=>$blog,'blogs'=>$blogs];

	   	// Return data and view
	   	return $this->view('blogs.show')->data($data)->title('View Blog - Blogs');

	}

	/**
	 * Display the specified blog tags resource.
	 *
	 * @param  string $slug
	 * @return Response
	 */
	public function tag($slug)
	{
		// Get data from database
        $blogs = Blog::whereTag($slug)->with('category')->orderBy('publish_date','ASC')->get();

		// Set data to view
		$data = ['tag'=>DB::table('tags')->where('slug', $slug)->first(),'blogs'=>$blogs];

	   	// Return data and view
	   	return $this->view('blogs.tag')->data($data)->title('View Blog Tags - Blog Tags');

	}

	/**
	 * Display the specified blog tags resource.
	 *
	 * @param  string $slug
	 * @return Response
	 */
	public function tags()
	{
		// Get data from database
		$blogs = Blog::active()->with('category')->orderBy('publish_date','ASC')->get();

		// Set data to view
		$data = ['tag'=>Blog::allTags()->get(),'blogs'=>$blogs];

		// Return data and view
		return $this->view('blogs.tag')->data($data)->title('View All Blog Tags - Blog Tags');

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
