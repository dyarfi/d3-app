<?php namespace App\Modules\Blog\Controller;

// Load Laravel classes
use Route, Request, Sentinel, Session, Redirect, Input, Validator, View;
// Load main base controller
use App\Modules\BaseAdmin;
// Load main models
use App\Modules\Blog\Model\Blog;
use App\Modules\Blog\Model\BlogCategory;
//use App\Modules\Blog\Model\Project;
//use App\Modules\Blog\Model\Client;

class BlogCategories extends BaseAdmin {
	/**
	 * Holds the Sentinel Users repository.
	 *
	 * @var \Cartalyst\Sentinel\Users\EloquentUser
	 */
	protected $categories;

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

		// Load categories and get repository data from database
		$this->categories = new BlogCategory;

	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index() {

		// Set return data
	   	$categories = Input::get('path') === 'trashed' ? $this->categories->onlyTrashed()->get() : $this->categories->orderBy('index', 'asc')->get();

	   	// Get deleted count
		$deleted = $this->categories->onlyTrashed()->get()->count();

	   	// Set data to return
	   	$data = ['rows' => $categories,'deleted' => $deleted,'junked' => Input::get('path')];

	   	// Load needed scripts
	   	$scripts = [
	   				'dataTables'=> 'themes/ace-admin/js/jquery.dataTables.min.js',
	   				'dataTableBootstrap'=> 'themes/ace-admin/js/jquery.dataTables.bootstrap.min.js',
	   				'dataTableTools'=> 'themes/ace-admin/js/dataTables.tableTools.min.js',
	   				'dataTablesColVis'=> 'themes/ace-admin/js/dataTables.colVis.min.js'
	   				];

		// Return data and view
	   	return $this->view('Blog::category_index')->data($data)->scripts($scripts)->title('Blog Category List');
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
        $category = $this->categories->find($id);

		// Set data to return
	   	$data = ['row'=>$category];

	   	// Return data and view
	   	return $this->view('Blog::category_show')->data($data)->title('View Blog Category');

	}

	/**
	 * Show the form for creating new category.
	 *
	 * @return \Illuminate\View\View
	 */
	public function create()
	{
		return $this->showForm('create');
	}

	/**
	 * Handle posting of the form for creating new category.
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function store()
	{
		return $this->processForm('create');
	}

	/**
	 * Show the form for updating category.
	 *
	 * @param  int  $id
	 * @return mixed
	 */
	public function edit($id)
	{
		return $this->showForm('update', $id);
	}

	/**
	 * Handle posting of the form for updating category.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function update($id)
	{
		return $this->processForm('update', $id);
	}

	/**
	 * Remove the specified category.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function trash($id)
	{
		if ($category = $this->categories->find($id))
		{
			// Add deleted_at and not completely delete
			$category->delete();

			// Redirect with messages
			return Redirect::to(route('admin.categories.index'))->with('success', 'Blog Category Trashed!');
		}

		return Redirect::to(route('admin.categories.index'))->with('error', 'Blog Category Not Found!');
	}

	/**
	 * Restored the specified category.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function restored($id)
	{
		if ($category = $this->categories->onlyTrashed()->find($id))
		{

			// Restored back from deleted_at database
			$category->restore();

			// Redirect with messages
			return Redirect::to(route('admin.categories.index'))->with('success', 'Blog Category Restored!');
		}

		return Redirect::to(route('admin.categories.index'))->with('error', 'Blog Category Not Found!');;
	}

	/**
	 * Delete the specified category.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function delete($id)
	{
		if ($category = $this->categories->onlyTrashed()->find($id))
		{

			// Completely delete from database
			$category->forceDelete();

			// Redirect with messages
			return Redirect::to(route('admin.categories.index'))->with('success', 'Blog Category Permanently Deleted!');
		}

		return Redirect::to(route('admin.categories.index'))->with('error', 'Blog Category Not Found!');
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
			if ( ! $row = $this->categories->find($id))
			{
				return Redirect::to(route('admin.categories.index'))->withErrors('Not found data!');;
			}
		}
		else
		{
			$row = $this->categories;
		}

		// Set model to form
		$model = $this->categories;

		return $this->view('Blog::category_form')->data(compact('mode','row','model'))->title('Blog Category '.$mode);
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

		// Set category slug
		$input['slug'] = isset($input['name']) ? str_slug($input['name'],'-') : '';

		$rules = [
			'name' 	   	   => 'required',
			//'slug' 		   => 'required',
			'description'  => 'required',
			'status'	   => 'boolean',
			//'image' 	   => ($mode == 'create' ? 'required|' : '').'mimes:jpg,jpeg,png|max:999',
			'index'	   	   => 'numeric|digits_between:1,999',
		];

		if ($id)
		{
			// Set default category
			$category = $this->categories->find($id);

			// Set validation messages
			$messages = $this->validateBlogCategory($input, $rules);

			// If user upload a file
			if (isset($input['image']) && Input::hasFile('image')) {

				// Set filename
				$filename = $this->imageUploadToDb($input['image'], 'uploads', 'category_');

			}

			if ($messages->isEmpty())
			{
				// Get all request
				$result = $input;

				// Slip user id
				$result = array_set($result, 'user_id', Sentinel::getUser()->id);

				// Slip image file
				$result = isset($filename) ? array_set($input, 'image', $filename) : $result;

				// Set input to database
				$category->update($result);
			}

		}
		else
		{

			// Set validation messages
			$messages = $this->validateBlogCategory($input, $rules);

			// If user upload a file
			if (isset($input['image']) && Input::hasFile('image')) {

				// Set filename
				$filename = $this->imageUploadToDb($input['image'], 'uploads', 'category_');

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
				$category = $this->categories->create($result);

			}
		}

		if ($messages->isEmpty())
		{
			return Redirect::to(route('admin.blogcategories.show',$category->id))->with('success', 'Blog Category Updated!');
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
				$this->categories->find($row)->update(['status' => Input::get('select_action')]);
		    }

		    // Set message
		    return Redirect::to(route('admin.categories.index'))->with('success', 'Blog Category Status Changed!');

		} else {

		    // Set message
		    return Redirect::to(route('admin.categories.index'))->with('error','Data not Available!');
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
			$destinationpath = public_path($path); // Upload path start with slashes
			$extension = $file->getClientOriginalExtension(); // Getting image extension
			$filename = $type . rand(11111,99999) . '.' . $extension; // Renaming image
			$file->move($destinationpath, $filename); // Uploading file and move to given path
		}

		return $filename;
	}

	/**
	 * Validates a category.
	 *
	 * @param  array  $data
	 * @param  mixed  $id
	 * @return \Illuminate\Support\MessageBag
	 */
	protected function validateBlogCategory($data, $rules)
	{
		$validator = Validator::make($data, $rules);

		$validator->passes();

		return $validator->errors();
	}

}
