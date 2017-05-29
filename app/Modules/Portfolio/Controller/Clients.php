<?php namespace App\Modules\Portfolio\Controller;

// Load Laravel classes
use Route, Request, Sentinel, Session, Redirect, Input, Validator, View;
// Load main base controller
use App\Modules\BaseAdmin;
// Load main models
use App\Modules\Portfolio\Model\Portfolio;
use App\Modules\Portfolio\Model\Project;
use App\Modules\Portfolio\Model\Client;

class Clients extends BaseAdmin {
	/**
	 * Holds the Sentinel Users repository.
	 *
	 * @var \Cartalyst\Sentinel\Users\EloquentUser
	 */
	protected $clients;

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

		// Load clients and get repository data from database
		$this->clients = new Client;

	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index() {

		// Set return data
	   	$clients = Input::get('path') === 'trashed' ? $this->clients->onlyTrashed()->get() : $this->clients->orderBy('index', 'asc')->get();

	   	// Get deleted count
		$deleted = $this->clients->onlyTrashed()->get()->count();

	   	// Set data to return
	   	$data = ['rows' => $clients,'deleted' => $deleted,'junked' => Input::get('path')];

	   	// Load needed scripts
	   	$scripts = [
	   				'dataTables'=> 'themes/ace-admin/js/jquery.dataTables.min.js',
	   				'dataTableBootstrap'=> 'themes/ace-admin/js/jquery.dataTables.bootstrap.min.js',
	   				'dataTableTools'=> 'themes/ace-admin/js/dataTables.tableTools.min.js',
	   				'dataTablesColVis'=> 'themes/ace-admin/js/dataTables.colVis.min.js'
	   				];

		// Return data and view
	   	return $this->view('Portfolio::client_index')->data($data)->scripts($scripts)->title('Client List');
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
        $client = $this->clients->find($id);

		// Set data to return
	   	$data = ['row'=>$client];

	   	// Return data and view
	   	return $this->view('Portfolio::client_show')->data($data)->title('View Client');

	}

	/**
	 * Show the form for creating new client.
	 *
	 * @return \Illuminate\View\View
	 */
	public function create()
	{
		return $this->showForm('create');
	}

	/**
	 * Handle posting of the form for creating new client.
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function store()
	{
		return $this->processForm('create');
	}

	/**
	 * Show the form for updating client.
	 *
	 * @param  int  $id
	 * @return mixed
	 */
	public function edit($id)
	{
		return $this->showForm('update', $id);
	}

	/**
	 * Handle posting of the form for updating client.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function update($id)
	{
		return $this->processForm('update', $id);
	}

	/**
	 * Remove the specified client.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function trash($id)
	{
		if ($client = $this->clients->find($id))
		{
			// Add deleted_at and not completely delete
			$client->delete();

			// Redirect with messages
			return Redirect::to(route('admin.clients.index'))->with('success', 'Client Trashed!');
		}

		return Redirect::to(route('admin.clients.index'))->with('error', 'Client Not Found!');
	}

	/**
	 * Restored the specified client.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function restored($id)
	{
		if ($client = $this->clients->onlyTrashed()->find($id))
		{

			// Restored back from deleted_at database
			$client->restore();

			// Redirect with messages
			return Redirect::to(route('admin.clients.index'))->with('success', 'Client Restored!');
		}

		return Redirect::to(route('admin.clients.index'))->with('error', 'Client Not Found!');;
	}

	/**
	 * Delete the specified client.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function delete($id)
	{
		if ($client = $this->clients->onlyTrashed()->find($id))
		{

			// Completely delete from database
			$client->forceDelete();

			// Redirect with messages
			return Redirect::to(route('admin.clients.index'))->with('success', 'Client Permanently Deleted!');
		}

		return Redirect::to(route('admin.clients.index'))->with('error', 'Client Not Found!');
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
			if ( ! $row = $this->clients->find($id))
			{
				return Redirect::to(route('admin.clients.index'))->withErrors('Not found data!');;
			}
		}
		else
		{
			$row = $this->clients;
		}

		// Set model to form
		$model = $this->clients;

		return $this->view('Portfolio::client_form')->data(compact('mode','row','model'))->title('Client '.$mode);
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

		// Set client slug
		$input['slug'] = isset($input['name']) ? str_slug($input['name'],'_') : '';

		$rules = [
			'name' 	   	   => 'required',
			//'slug' 		   => 'required',
			'description'  => 'required',
			'status'	   => 'boolean',
			'image' 	   => ($mode == 'create' ? 'required|' : '').'mimes:jpg,jpeg,png|max:999',
			'index'	   	   => 'numeric|digits_between:1,999',
		];

		if ($id)
		{
			// Set default client
			$client = $this->clients->find($id);

			// Set validation messages
			$messages = $this->validateClient($input, $rules);

			// If user upload a file
			if (isset($input['image']) && Input::hasFile('image')) {

				// Set filename
				$filename = $this->imageUploadToDb($input['image'], 'uploads', 'client_');

			}

			if ($messages->isEmpty())
			{
				// Get all request
				$result = $input;

				// Slip user id
				$result = array_set($result, 'user_id', Sentinel::getUser()->id);

				// Slip image file
				$result = array_set($result, 'image', @$filename);

				// Set input to database
				$client->update($result);
			}

		}
		else
		{

			// Set validation messages
			$messages = $this->validateClient($input, $rules);

			// If user upload a file
			if (isset($input['image']) && Input::hasFile('image')) {

				// Set filename
				$filename = $this->imageUploadToDb($input['image'], 'uploads', 'client_');

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
				$client = $this->clients->create($result);

			}
		}

		if ($messages->isEmpty())
		{
			return Redirect::to(route('admin.clients.index'))->with('success', 'Client Updated!');
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
				$this->clients->find($row)->update(['status' => Input::get('select_action')]);
		    }

		    // Set message
		    return Redirect::to(route('admin.clients.index'))->with('success', 'Client Status Changed!');

		} else {

		    // Set message
		    return Redirect::to(route('admin.clients.index'))->with('error','Data not Available!');
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
	 * Validates a client.
	 *
	 * @param  array  $data
	 * @param  mixed  $id
	 * @return \Illuminate\Support\MessageBag
	 */
	protected function validateClient($data, $rules)
	{
		$validator = Validator::make($data, $rules);

		$validator->passes();

		return $validator->errors();
	}

}
