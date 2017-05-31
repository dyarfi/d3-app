<?php namespace App\Modules\Blog\Controller;

// Load Laravel classes
use Route, Request, Sentinel, Session, Redirect, Input, Validator, View, Image;
// Load main base controller
use App\Modules\BaseAdmin;
// Load main models
use App\Modules\Blog\Model\Blog, App\Modules\Blog\Model\BlogCategory;

class Blogs extends BaseAdmin {
	/**
	 * Holds the Sentinel Users repository.
	 *
	 * @var \Cartalyst\Sentinel\Users\EloquentUser
	 */
	protected $blogs;

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{

		// Parent constructor
		parent::__construct();

		// Load Http/Middleware/Admin controller
		$this->middleware('auth.admin');

		// Load blogs and get repository data from database
		$this->blogs 		= new Blog;
		$this->categories	= new BlogCategory;

		// Crop to fit image size
		$this->imgFit 		= [1200,1200];


		// Get the entity object
		$product = $this->blogs->find(1);

		// Through a string
		//$product->tag('foo, bar, baz');

		// Through an array
		//$product->tag([ 'foo', 'bar', 'baz' ]);
		//dd($product->tags()->get());

	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index() {

		// Set return data
	   	$blogs = Input::get('path') === 'trashed' ? $this->blogs->with('project')->onlyTrashed()->get() : $this->blogs->with('project')->orderBy('index', 'asc')->get();

	   	// Get deleted count
		$deleted = $this->blogs->onlyTrashed()->get()->count();

	   	// Set data to return
	   	$data = ['rows' => $blogs,'deleted' => $deleted,'junked' => Input::get('path')];

	   	// Load needed scripts
	   	$scripts = [
	   				'dataTables'=> asset('themes/ace-admin/js/jquery.dataTables.min.js'),
	   				'dataTableBootstrap'=> asset('themes/ace-admin/js/jquery.dataTables.bootstrap.min.js'),
	   				'dataTableTools'=> asset('themes/ace-admin/js/dataTables.tableTools.min.js'),
	   				'dataTablesColVis'=> asset('themes/ace-admin/js/dataTables.colVis.min.js')
	   				];

		// Return data and view
	   	return $this->view('Blog::blog_index')->data($data)->scripts($scripts)->title('Blog List');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		// Get data from database
        $blog = $this->blogs->find($id);

		// Set data to return
	   	$data = ['row'=>$blog];

	   	// Return data and view
	   	return $this->view('Blog::blog_show')->data($data)->title('View Blog');

	}

	/**
	 * Show the form for creating new blog.
	 *
	 * @return \Illuminate\View\View
	 */
	public function create()
	{
		return $this->showForm('create');
	}

	/**
	 * Handle posting of the form for creating new blog.
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function store()
	{
		return $this->processForm('create');
	}

	/**
	 * Show the form for updating blog.
	 *
	 * @param  int  $id
	 * @return mixed
	 */
	public function edit($id)
	{
		return $this->showForm('update', $id);
	}

	/**
	 * Handle posting of the form for updating blog.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function update($id)
	{
		return $this->processForm('update', $id);
	}

	/**
	 * Remove the specified blog.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function trash($id)
	{
		if ($blog = $this->blogs->find($id))
		{
			// Add deleted_at and not completely delete
			$blog->delete();

			// Redirect with messages
			return Redirect::to(route('admin.blogs.index'))->with('success', 'Blog Trashed!');
		}

		return Redirect::to(route('admin.blogs.index'))->with('error', 'Blog Not Found!');
	}

	/**
	 * Restored the specified blog.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function restored($id)
	{
		if ($blog = $this->blogs->onlyTrashed()->find($id))
		{

			// Restored back from deleted_at database
			$blog->restore();

			// Redirect with messages
			return Redirect::to(route('admin.blogs.index'))->with('success', 'Blog Restored!');
		}

		return Redirect::to(route('admin.blogs.index'))->with('error', 'Blog Not Found!');;
	}

	/**
	 * Delete the specified blog.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function delete($id)
	{
		if ($blog = $this->blogs->onlyTrashed()->find($id))
		{

			// Completely delete from database
			$blog->forceDelete();

			// Redirect with messages
			return Redirect::to(route('admin.blogs.index'))->with('success', 'Blog Permanently Deleted!');
		}

		return Redirect::to(route('admin.blogs.index'))->with('error', 'Blog Not Found!');
	}

	/**
	 * Shows the form.
	 *
	 * @param  string  $mode
	 * @param  int     $id
	 * @return mixed
	 */
	protected function showForm($mode, $id = null)
	{

		if ($id)
		{
			if ( ! $row = $this->blogs->find($id))
			{
				return Redirect::to(route('admin.blogs.index'))->withErrors('Not found data!');;
			}
			$tags 		= $row->tags;
		}
		else
		{
			$row 		= $this->blogs;
			$tags 		= $this->blogs->allTags();
		}

		$model	 	= $this->blogs;

		$categories = $this->categories->lists('name', 'id')->all();

		//$projects 	= $this->projects->lists('name', 'id')->all();

		$tags		= $tags;

		$scripts = [
			'bootstrap-tag'=>asset("themes/ace-admin/js/bootstrap-tag.min.js"),
			'library'=>asset("themes/ace-admin/js/library.js")
		];

		return $this->view('Blog::blog_form')->data(compact('mode','row','categories','blogs','tags','model'))->scripts($scripts)->title('Blog '.$mode);
	}

	/**
	 * Processes the form.
	 *
	 * @param  string  $mode
	 * @param  int     $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	protected function processForm($mode, $id = null)
	{

		// Filter all input
		$input = array_filter(Input::all());

		// Set blog slug
		$input['slug'] = isset($input['name']) ? str_slug($input['name'],'_') : '';

		$rules = [
			'client_id'   => 'required',
			'project_id'  => 'required',
			'name' 	   	  => 'required',
			//'slug' 		   => 'required',
			'description'  => 'required',
			'status'	   => 'boolean',
			'image' 	   => ($mode == 'create' ? 'required|' : '').'mimes:jpg,jpeg,png|max:999',
			'index'	   	   => 'numeric|digits_between:1,999',
		];
		if ($id)
		{
			// Set default blog
			$blog 	= $this->blogs->find($id);

			// Set validation messages
			$messages 	= $this->validateBlog($input, $rules);

			// If user upload a file
			if (isset($input['image']) && Input::hasFile('image')) {

				// Set filename
				$filename = $this->imageUploadToDb($input['image'], 'uploads', 'blog_');

			}

			// If validation message empty
			if ($messages->isEmpty())
			{
				// Get all request
				$result = $input;

				// Slip user id
				$result = array_set($result, 'user_id', Sentinel::getUser()->id);

				// Slip image file
				$result = isset($filename) ? array_set($input, 'image', $filename) : $result;

				// Set input to database
				$blog->update($result);

				// Using the `slug` column
				$blog->setTags($result['tags']);

			}

		}
		else
		{

			// Set validation messages
			$messages = $this->validateBlog($input, $rules);

			// If user upload a file
			if (isset($input['image']) && Input::hasFile('image')) {

				// Set filename
				$filename = $this->imageUploadToDb($input['image'], 'uploads', 'blog_');

			}

			if ($messages->isEmpty())
			{
				// Get all request
				$result = $input;

				// Slip user id
				$result = array_set($result, 'user_id', Sentinel::getUser()->id);

				// Slip image file
				$result = isset($input['image']) ? array_set($result, 'image', @$filename) : array_set($result, 'image', '');

				// Set input to database
				$blog = $this->blogs->create($result);

				// Using the `slug` column
				$blog->setTags($result['tags']);

			}
		}

		if ($messages->isEmpty())
		{
			return Redirect::to(route('admin.blogs.index'))->with('success', 'Blog Updated!');
		}

		return Redirect::back()->withInput()->withErrors($messages);
	}

	/**
	 * Change the data status.
	 *
	 * @param  int     $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	protected function change() {

		if (Input::get('check') !='') {

		    $rows	= Input::get('check');

		    foreach ($rows as $row) {
				// Set id for load and change status
				$this->blogs->find($row)->update(['status' => Input::get('select_action')]);
		    }

		    // Set message
		    return Redirect::to(route('admin.blogs.index'))->with('success', 'Blog Status Changed!');

		} else {

		    // Set message
		    return Redirect::to(route('admin.blogs.index'))->with('error','Data not Available!');
		}
	}

	/**
	 * List Taggable data at the specified blog.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function tags($id='')
	{
		if ($id) {
			if ($blog = $this->blogs->find($id)) {
				// Return Json Response
				return response()->json($blog->tags->lists('name'), 200);
			}
		} else {
			// Return Json Response
			return response()->json($this->blogs->allTags()->lists('name'), 200);
		}
	}

	/**
	 * Process a file upload save the filename to DB.
	 *
	 * @param  array  $file
	 * @param  string $path
	 * @param  string $type
	 * @return $filename
	 */
	protected function imageUploadToDb($file='', $path='', $type='')
	{
		// Set filename upload
		$filename = '';

		// Check if input and upload already assigned
		if (!empty($file) && !$file->getError()) {

			// Upload path
			$destinationpath = public_path($path);
			// Getting image extension
			$extension = $file->getBlogCategoryOriginalExtension();
			// Renaming image
			$filename = $type . rand(11111,99999) . '.' . $extension;
			// Uploading file and move to given path
			$file->move($destinationpath, $filename);
			// Set intervention image for image manipulation
			$image_fit = implode('x',$this->imgFit);
			$image = Image::make($path .'/'. $filename);
			$image->fit($this->imgFit[0],$this->imgFit[1])->save($path .'/'. $image_fit.'px_'. $filename);

		}

		return $filename;
	}

	/**
	 * Validates a blog.
	 *
	 * @param  array  $data
	 * @param  mixed  $id
	 * @return \Illuminate\Support\MessageBag
	 */
	protected function validateBlog($data, $rules)
	{
		$validator = Validator::make($data, $rules);

		$validator->passes();

		return $validator->errors();
	}


}
