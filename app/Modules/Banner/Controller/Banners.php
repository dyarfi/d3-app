<?php namespace App\Modules\Banner\Controller;

// Load Laravel classes
use Route, Request, Session, Redirect, Input, Image, Validator, View;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
// Load main base controller
use App\Modules\BaseAdmin;
// Load main models
use App\Modules\Banner\Model\Banner;

class Banners extends BaseAdmin {

	/**
	 * Set banner data.
	 *
	 */
	protected $banners;

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

		// Load banners and get repository data from database
		$this->banners = new Banner;

	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index() {

		// Set return data
	   	$banners = Input::get('path') === 'trashed' ? $this->banners->onlyTrashed()->get() : $this->banners->orderBy('created_at','desc')->get();

	   	// Get deleted count
		$deleted = $this->banners->onlyTrashed()->get()->count();

	   	// Set data to return
	   	$data = ['rows' => $banners,'deleted' => $deleted,'junked' => Input::get('path')];

		// Load needed scripts
	   	$scripts = [
	   				'dataTables'=> 'themes/ace-admin/js/jquery.dataTables.min.js',
	   				'dataTableBootstrap'=> 'themes/ace-admin/js/jquery.dataTables.bootstrap.min.js',
	   				'dataTableTools'=> 'themes/ace-admin/js/dataTables.tableTools.min.js',
	   				'dataTablesColVis'=> 'themes/ace-admin/js/dataTables.colVis.min.js'
	   				];

		// Return data and view
	   	return $this->view('Banner::banner_index')->data($data)->scripts($scripts)->title('Banner List');
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
        $banner = $this->banners->find($id);

		// Set data to return
	   	$data = ['row'=>$banner];

	   	// Return data and view
	   	return $this->view('Banner::banner_show')->data($data)->title('View Banner');

	}

	/**
	 * Show the form for creating new banner.
	 *
	 * @return \Illuminate\View\View
	 */
	public function create()
	{
		return $this->showForm('create');
	}

	/**
	 * Handle posting of the form for creating new banner.
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function store()
	{
		return $this->processForm('create');
	}

	/**
	 * Show the form for updating banner.
	 *
	 * @param  int  $id
	 * @return mixed
	 */
	public function edit($id)
	{
		return $this->showForm('update', $id);
	}

	/**
	 * Handle posting of the form for updating banner.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function update($id)
	{
		return $this->processForm('update', $id);
	}

	/**
	 * Remove the specified banner.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function trash($id)
	{
		if ($banner = $this->banners->find($id))
		{
			// Add deleted_at and not completely delete
			$banner->delete();

			// Redirect with messages
			return Redirect::to(route('admin.banners.index'))->with('success', 'Banner Trashed!');
		}

		return Redirect::to(route('admin.banners.index'))->with('error', 'Banner Not Found!');
	}

	/**
	 * Restored the specified banner.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function restored($id)
	{
		if ($banner = $this->banners->onlyTrashed()->find($id))
		{

			// Restored back from deleted_at database
			$banner->restore();

			// Redirect with messages
			return Redirect::to(route('admin.banners.index'))->with('success', 'Banner Restored!');
		}

		return Redirect::to(route('admin.banners.index'))->with('error', 'Banner Not Found!');;
	}

	/**
	 * Delete the specified banner.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function delete($id)
	{
		if ($banner = $this->banners->onlyTrashed()->find($id))
		{

			// Completely delete from database
			$banner->forceDelete();

			// Redirect with messages
			return Redirect::to(route('admin.banners.index'))->with('success', 'Banner Permanently Deleted!');
		}

		return Redirect::to(route('admin.banners.index'))->with('error', 'Banner Not Found!');
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
			if ( ! $row = $this->banners->find($id))
			{
				return Redirect::to(route('admin.banners.index'))->withErrors('Not found data!');;
			}
		}
		else
		{
			$row = $this->banners;
		}

		// Set division model to name and id only for lookup input
		//$divisions = $this->divisions->lists('name', 'id')->all();

	   	// Load needed javascripts
	   	$scripts = ['bootstrap-datepicker'=> 'themes/ace-admin/js/bootstrap-datepicker.min.js'];

		// Load needed stylesheets
	   	$styles = ['stylesheet'=> 'themes/ace-admin/css/datepicker.min.css'];

		return $this->view('Banner::banner_form')->data(compact('mode', 'row'/*,'divisions'*/))->scripts($scripts)->styles($styles)->title('Banner '.$mode);
	}

	/**
	 * Processes the form.
	 *
	 * @param  string  $mode
	 * @param  int     $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	protected function processForm($mode, $id = null) {

		$input = array_filter(Input::all());

		$rules = [
			'name' 	   	   => 'required',
			'slug' 		   => 'required',
			'description'  => 'required',
			'image'  	   => ($mode == 'create') ? 'required' : '',
			'status'	   => 'boolean'
		];

		if ($id)
		{
			$banner = $this->banners->find($id);

			$messages = $this->validateBanner($input, $rules);

			// If user upload a file
			if (isset($input['image']) && Input::hasFile('image')) {

				// Set filename
				$filename = $this->imageUploadToDb($input['image'], 'uploads', 'banner_');

			}
			else {

				$filename = $banner->image;

			}

			if ($messages->isEmpty())
			{
				// Get all request
				$result = $input;

				// Slip user id
				$result = array_set($result, 'user_id', $this->user->id);

				// Slip image file
				$result = isset($filename) ? array_set($input, 'image', $filename) : $result;

				$banner->update($result);
			}

		}
		else
		{
			$messages = $this->validateBanner($input, $rules);

			// If user upload a file
			if (isset($input['image']) && Input::hasFile('image')) {

				// Set filename
				$filename = $this->imageUploadToDb($input['image'], 'uploads', 'banner_');

			}

			if ($messages->isEmpty())
			{
				// Get all request
				$result = $input;

				// Slip user id
				$result = array_set($result, 'user_id', $this->user->id);

				// Slip image file
				$result = isset($input['image']) ? array_set($result, 'image', @$filename) : array_set($result, 'image', '');

				//$banner = $this->banners->create($input);
				$banner = $this->banners->create($result);

			}
		}

		if ($messages->isEmpty())
		{
			return Redirect::to(route('admin.banners.show', $banner->id))->with('success', 'Banner Updated!');
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
				$this->banners->find($row)->update(['status' => Input::get('select_action')]);
		    }

		    // Set message
		    return Redirect::to(route('admin.banners.index'))->with('success', 'Banner Status Changed!');

		} else {

		    // Set message
		    return Redirect::to(route('admin.banners.index'))->with('error','Data not Available!');
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
	 * Validates a banner.
	 *
	 * @param  array  $data
	 * @param  mixed  $id
	 * @return \Illuminate\Support\MessageBag
	 */
	protected function validateBanner($data, $rules)
	{
		$validator = Validator::make($data, $rules);

		$validator->passes();

		return $validator->errors();
	}


}
