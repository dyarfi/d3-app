<?php namespace App\Http\Controllers;

// Load Laravel classes
use Request, DB;

// Load datetime helper
use Carbon\Carbon;

// Load main models
use App\Modules\Page\Model\Menu, App\Modules\Page\Model\Page;

// Load models
use App\Modules\Blog\Model\Blog;
use App\Modules\Blog\Model\BlogCategory;
use App\Modules\Portfolio\Model\Portfolio;

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

	/**
	 * Display a listing of the blogs resource.
	 *
	 * @return Response
	 */
	public function index()
	{

		// Get the page path that requested
		$path = Request::segment(1);

		// Get active blogs with paginated
		$blogs = Blog::active()->with('category')->with('tags')->orderBy('index','ASC')->paginate(10);

		// Set data to return
	   	$data = [
			'menu' =>$this->menu->where('slug', $path)->first(),
			'blogs' =>$blogs
		];

		// Return view
		return $this->view('menus.blog')->data($data)->title('Page | Blog');

	}

	/**
	 * Display the specified blogresource.
	 *
	 * @param  string $slug
	 * @return Response
	 */
	public function show($slug)
	{
		// Get the page path that requested
		$path = Request::segment(1);

		// Get data from database
        $blog = Blog::where('slug',$slug)->with('category')->with('tags')->with('user')->first();

		// Get data list from database
		$blogs = Blog::active()->with('category')->with('tags')->orderBy('publish_date','ASC')->get();

		// Set data to view
		$data = [
			'menu' =>$this->menu->where('slug', $path)->first(),
			'blog' => $blog,
			'blogs' => $blogs,
			'portfolios' => Portfolio::active()->with('client')->with('project')->orderBy('created_at','DESC')->take(10)->get(),
			'tags' => Blog::allTags()->get()
		];

	   	// Return data and view
	   	return $this->view('blogs.show')->data($data)->title('View Blog - '.$blog->name.' By : '.$blog->user->first_name.' '.$blog->user->last_name);

	}

	/**
	 * Display the specified blog tags resource.
	 *
	 * @param  string $slug
	 * @return Response
	 */
	public function tag($slug)
	{
		// Get the page path that requested
		$path = Request::segment(1);

		// Get data from database
        $blogs = Blog::whereTag($slug)->with('category')->orderBy('publish_date','ASC')->get();

		// Set data to view
		$data = [
				'menu' =>$this->menu->where('slug', $path)->first(),
				'tag'=>DB::table('tags')->where('slug', $slug)->first(),
				'blogs'=>$blogs
			];

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
		// Get the page path that requested
		$path = Request::segment(1);

		// Get data from database
		$blogs = Blog::active()->with('category')->orderBy('publish_date','ASC')->get();

		// Set data to view
		$data = [
				'menu' =>$this->menu->where('slug', $path)->first(),
				'tag'=>Blog::allTags()->get(),
				'blogs'=>$blogs
			];

		// Return data and view
		return $this->view('blogs.tag')->data($data)->title('View All Blog Tags - Blog Tags');

	}

	/**
	 * Display the specified blog category resource.
	 *
	 * @param  string $slug
	 * @return Response
	 */
	public function category($slug)
	{
		// Get the page path that requested
		$path = Request::segment(1);

		// Get category data from database
		$category = BlogCategory::slug($slug);

		// Get all blogs with category id data from database
        $blogs = Blog::where('category_id',$category->id)->orderBy('publish_date','ASC')->get();

		// Set data to view
		$data = [
			'menu' =>$this->menu->where('slug', $path)->first(),
			'category'=>$category,
			'blogs'=>$blogs
		];

	   	// Return data and view
	   	return $this->view('blogs.category')->data($data)->title('View Blog Categories - Blog Categories');

	}

	/**
	 * Display the specified blog categories resource.
	 *
	 * @param  string $slug
	 * @return Response
	 */
	public function categories()
	{
		// Get the page path that requested
		$path = Request::segment(1);

		// Get data from database
		$blogs = Blog::active()->with('category')->orderBy('publish_date','ASC')->get();

		// Set data to view
		$data = [
			'menu' =>$this->menu->where('slug', $path)->first(),
			'category'=>BlogCategory::active()->get(),
			'blogs'=>$blogs
		];

		// Return data and view
		return $this->view('blogs.category')->data($data)->title('View All Blog Categories - Blog Categories');

	}

}
