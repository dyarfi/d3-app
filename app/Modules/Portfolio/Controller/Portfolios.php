<?php namespace App\Modules\Portfolio\Controller;

// Load Laravel classes
use Route, Request, Sentinel, Session, Redirect, Input, Validator, View;
// Load main base controller
use App\Modules\BaseAdmin;
// Load main models
use App\Modules\Portfolio\Model\Portfolio,App\Modules\Portfolio\Model\Project,App\Modules\Portfolio\Model\Client;

class Portfolios extends BaseAdmin {
	/**
	 * Holds the Sentinel Users repository.
	 *
	 * @var \Cartalyst\Sentinel\Users\EloquentUser
	 */
	protected $portfolios;

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

		// Load portfolios and get repository data from database
		$this->portfolios 	= new Portfolio;
		$this->clients 		= new Client;
		$this->projects 	= new Project;

	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index() {

		// Set return data
	   	$portfolios = Input::get('path') === 'trashed' ? $this->portfolios->with('project')->onlyTrashed()->get() : $this->portfolios->with('project')->orderBy('index', 'asc')->get();

	   	// Get deleted count
		$deleted = $this->portfolios->onlyTrashed()->get()->count();

	   	// Set data to return
	   	$data = ['rows' => $portfolios,'deleted' => $deleted,'junked' => Input::get('path')];

	   	// Load needed scripts
	   	$scripts = [
	   				'dataTables'=> 'themes/ace-admin/js/jquery.dataTables.min.js',
	   				'dataTableBootstrap'=> 'themes/ace-admin/js/jquery.dataTables.bootstrap.min.js',
	   				'dataTableTools'=> 'themes/ace-admin/js/dataTables.tableTools.min.js',
	   				'dataTablesColVis'=> 'themes/ace-admin/js/dataTables.colVis.min.js'
	   				];

		// Return data and view
	   	return $this->view('Portfolio::portfolio_index')->data($data)->scripts($scripts)->title('Portfolio List');
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
        $portfolio = $this->portfolios->find($id);

		// Set data to return
	   	$data = ['row'=>$portfolio];

	   	// Return data and view
	   	return $this->view('Portfolio::portfolio_show')->data($data)->title('View Portfolio');

	}

	/**
	 * Show the form for creating new portfolio.
	 *
	 * @return \Illuminate\View\View
	 */
	public function create()
	{
		return $this->showForm('create');
	}

	/**
	 * Handle posting of the form for creating new portfolio.
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function store()
	{
		return $this->processForm('create');
	}

	/**
	 * Show the form for updating portfolio.
	 *
	 * @param  int  $id
	 * @return mixed
	 */
	public function edit($id)
	{
		return $this->showForm('update', $id);
	}

	/**
	 * Handle posting of the form for updating portfolio.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function update($id)
	{
		return $this->processForm('update', $id);
	}

	/**
	 * Remove the specified portfolio.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function trash($id)
	{
		if ($portfolio = $this->portfolios->find($id))
		{
			// Add deleted_at and not completely delete
			$portfolio->delete();

			// Redirect with messages
			return Redirect::to(route('admin.portfolios.index'))->with('success', 'Portfolio Trashed!');
		}

		return Redirect::to(route('admin.portfolios.index'))->with('error', 'Portfolio Not Found!');
	}

	/**
	 * Restored the specified portfolio.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function restored($id)
	{
		if ($portfolio = $this->portfolios->onlyTrashed()->find($id))
		{

			// Restored back from deleted_at database
			$portfolio->restore();

			// Redirect with messages
			return Redirect::to(route('admin.portfolios.index'))->with('success', 'Portfolio Restored!');
		}

		return Redirect::to(route('admin.portfolios.index'))->with('error', 'Portfolio Not Found!');;
	}

	/**
	 * Delete the specified portfolio.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function delete($id)
	{
		if ($portfolio = $this->portfolios->onlyTrashed()->find($id))
		{

			// Completely delete from database
			$portfolio->forceDelete();

			// Redirect with messages
			return Redirect::to(route('admin.portfolios.index'))->with('success', 'Portfolio Permanently Deleted!');
		}

		return Redirect::to(route('admin.portfolios.index'))->with('error', 'Portfolio Not Found!');
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
			if ( ! $row = $this->portfolios->find($id))
			{
				return Redirect::to(route('admin.portfolios.index'))->withErrors('Not found data!');;
			}
		}
		else
		{
			$row = $this->portfolios;
		}

		$model	 = $this->portfolios;

		$clients = $this->clients->lists('name', 'id')->all();

		$projects = $this->projects->lists('name', 'id')->all();

		return $this->view('Portfolio::portfolio_form')->data(compact('mode','row','clients','projects','portfolios','model'))->title('Portfolio '.$mode);
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

		// Set portfolio slug
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
			// Set default portfolio
			$portfolio 	= $this->portfolios->find($id);

			// Set validation messages
			$messages 	= $this->validatePortfolio($input, $rules);

			// If user upload a file
			if (isset($input['image']) && Input::hasFile('image')) {

				// Set filename
				$filename = $this->imageUploadToDb($input['image'], '/uploads', 'portfolio_');

			}

			// If validation message empty
			if ($messages->isEmpty())
			{
				// Get all request
				$result = $input;

				// Slip user id
				$result = array_set($result, 'user_id', Sentinel::getUser()->id);

				// Slip image file
				$input = array_set($input, 'image', @$filename);

				// Set input to database
				$portfolio->update($result);
			}

		}
		else
		{

			// Set validation messages
			$messages = $this->validatePortfolio($input, $rules);

			// If user upload a file
			if (isset($input['image']) && Input::hasFile('image')) {

				// Set filename
				$filename = $this->imageUploadToDb($input['image'], '/uploads', 'portfolio_');

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
				$portfolio = $this->portfolios->create($result);

			}
		}

		if ($messages->isEmpty())
		{
			return Redirect::to(route('admin.portfolios.index'))->with('success', 'Portfolio Updated!');
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
				$this->portfolios->find($row)->update(['status' => Input::get('select_action')]);
		    }

		    // Set message
		    return Redirect::to(route('admin.portfolios.index'))->with('success', 'Portfolio Status Changed!');

		} else {

		    // Set message
		    return Redirect::to(route('admin.portfolios.index'))->with('error','Data not Available!');
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
			$destinationpath = public_path() . $path; // Upload path start with slashes
			$extension = $file->getClientOriginalExtension(); // Getting image extension
			$filename = $type . rand(11111,99999) . '.' . $extension; // Renaming image
			$file->move($destinationpath, $filename); // Uploading file and move to given path
		}

		return $filename;
	}

	/**
	 * Validates a portfolio.
	 *
	 * @param  array  $data
	 * @param  mixed  $id
	 * @return \Illuminate\Support\MessageBag
	 */
	protected function validatePortfolio($data, $rules)
	{
		$validator = Validator::make($data, $rules);

		$validator->passes();

		return $validator->errors();
	}


}
