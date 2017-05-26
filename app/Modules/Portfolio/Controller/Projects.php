<?php namespace App\Modules\Portfolio\Controller;

// Load Laravel classes
use Route, Request, Sentinel, Session, Redirect, Input, Validator, View;
// Load main base controller
use App\Modules\BaseAdmin;
// Load main models
use App\Modules\Portfolio\Model\Portfolio, App\Modules\Portfolio\Model\Project, App\Modules\Portfolio\Model\Client;

class Projects extends BaseAdmin {

	/**
	 * Holds the Sentinel Projects repository.
	 *
	 * @var \Cartalyst\Sentinel\Projects\EloquentProject
	 */
	public $projects;

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

		// Load projects and get repository data from Sentinel
		$this->projects = new Project;
		$this->portfolios = new Portfolio;
		$this->clients = new Client;

	}

	/**
	 * Display a listing of projects.
	 *
	 * @return \Illuminate\View\View
	 */
	public function index()
	{

	   	//dd ($this->projects->find(1)->roles);

		// Set return data
	   	$projects = Input::get('path') === 'trashed' ? $this->projects->with('client')->onlyTrashed() : $this->projects->get();

	   	// Get deleted count
		$deleted = $this->projects->with('client')->onlyTrashed()->get()->count();

	   	// Set data to return
	   	$data = ['rows'=>$projects,'deleted'=>$deleted,'junked'=>Input::get('path')];

  		// Load needed scripts
	   	$scripts = [
	   				'dataTables'=> 'themes/ace-admin/js/jquery.dataTables.min.js',
	   				'dataTableBootstrap'=> 'themes/ace-admin/js/jquery.dataTables.bootstrap.min.js',
	   				'dataTableTools'=> 'themes/ace-admin/js/dataTables.tableTools.min.js',
	   				'dataTablesColVis'=> 'themes/ace-admin/js/dataTables.colVis.min.js'
	   				];

	   	return $this->view('Portfolio::project_index')->data($data)->scripts($scripts)->title('Projects List');
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
        $project = $this->projects->findOrFail($id);

		// Set data to return
	   	$data = ['row'=>$project];

	   	// Return data and view
	   	return $this->view('Portfolio::project_show')->data($data)->title('View Project');

	}

	/**
	 * Show the form for creating new project.
	 *
	 * @return \Illuminate\View\View
	 */
	public function create()
	{
		return $this->showForm('create');
	}

	/**
	 * Handle posting of the form for creating new project.
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function store()
	{
		return $this->processForm('create');
	}

	/**
	 * Show the form for updating project.
	 *
	 * @param  int  $id
	 * @return mixed
	 */
	public function edit($id)
	{
		return $this->showForm('update', $id);
	}

	/**
	 * Handle posting of the form for updating project.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function update($id)
	{
		return $this->processForm('update', $id);
	}

	/**
	 * Remove the specified project.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function trash($id)
	{
		if ($project = $this->projects->find($id))
		{

			// Add deleted_at and not completely delete
			$project->delete();

			// Redirect with messages
			return Redirect::to(route('admin.projects.index'))->with('success', 'Project Trashed!');
		}

		return Redirect::to(route('admin.projects.index'))->with('error', 'Project Not Found!');
	}

	/**
	 * Restored the specified project.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function restored($id)
	{
		if ($project = $this->projects->onlyTrashed()->find($id))
		{

			// Restored back from deleted_at database
			$project->restore();

			// Redirect with messages
			return Redirect::to(route('admin.projects.index'))->with('success', 'Project Restored!');
		}

		return Redirect::to(route('admin.projects.index'))->with('error', 'Project Not Found!');
	}
	/**
	 * Remove the specified project.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function delete($id)
	{

		// Get project from id fetch
		if ($project = $this->projects->onlyTrashed()->find($id))
		{

			// Delete from pivot table many to many
			$this->projects->onlyTrashed()->find($id)->roles()->detach();

			// Permanently delete
			$project->forceDelete();

			return Redirect::to(route('admin.projects.index'))->with('success', 'Project Permanently Deleted!');
		}

		return Redirect::to(route('admin.projects.index'))->with('error', 'Project Not Found!');
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
			if ( ! $row = $this->projects->find($id))
			{
				return Redirect::to(route('admin.projects.index'));
			}
		}
		else
		{
			$row = $this->projects;
		}

		$clients = $this->clients->lists('name', 'id')->all();

		return $this->view('Portfolio::project_form')->data(compact('mode', 'row', 'clients'))->title('Project '.$mode);
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
		$input = array_filter(Input::all());

		$rules = [
			'client_id' => 'required',
			'name'  => 'required',
			'description' => 'required',
			'status' => 'required'
		];

		if ($id)
		{

			$project = $this->projects->find($id);
			$messages = $this->validateProject($input, $rules);

			if ($messages->isEmpty())
			{

				// Update project model data
				$project->update($input);

			}
		}
		else
		{

			$messages = $this->validateProject($input, $rules);

			if ($messages->isEmpty())
			{
				// Create project into the database
				$project = $this->projects->create($input);

			}
		}

		if ($messages->isEmpty())
		{
			return Redirect::to(route('admin.projects.index'))->with('success', 'Project Updated!');;
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
				$this->projects->find($row)->update(['status' => Input::get('select_action')]);
		    }

		    // Set message
		    return Redirect::to(route('admin.projects.index'))->with('success', 'Project Status Changed!');

		} else {

		    // Set message
		    return Redirect::to(route('admin.projects.index'))->with('error','Data not Available!');
		}
	}

	/**
	 * Validates a project.
	 *
	 * @param  array  $data
	 * @param  mixed  $id
	 * @return \Illuminate\Support\MessageBag
	 */
	protected function validateProject($data, $rules)
	{
		$validator = Validator::make($data, $rules);

		$validator->passes();

		return $validator->errors();
	}

}
