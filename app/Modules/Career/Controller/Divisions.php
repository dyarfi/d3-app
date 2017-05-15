<?php namespace App\Modules\Career\Controller;

// Load Laravel classes
use Route, Request, Sentinel, Session, Redirect, Input, Validator, View;
// Load main base controller
use App\Modules\BaseAdmin;
// Load main models
use App\Modules\Career\Model\Division;
// Load the vendor libraries
use Excel;

class Divisions extends BaseAdmin {

	/**
	 * Holds the Sentinel Division repository.
	 *
	 * @var \Cartalyst\Sentinel\Division\EloquentDivision
	 */
	protected $division;

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

		// Load division and get repository data from Auth
		$this->division = new Division;
				
	}

	/**
	 * Display a listing of division.
	 *
	 * @return \Illuminate\View\View
	 */
	public function index()
	{

	   	//dd ($this->division->find(1)->roles);

		// Set return data 
	   	$divisions = Input::get('path') === 'trashed' ? $this->division->onlyTrashed()->get() : $this->division->orderBy('created_at','desc')->get();

	   	// Get deleted count
		$deleted = $this->division->onlyTrashed()->get()->count();
	   	
	   	// Set data to return
	   	$data = ['rows'=>$divisions,'deleted'=>$deleted,'junked'=>Input::get('path')];

   		// Load needed scripts
	   	$scripts = [
	   				'dataTables'=> 'themes/ace-admin/js/jquery.dataTables.min.js',
	   				'dataTableBootstrap'=> 'themes/ace-admin/js/jquery.dataTables.bootstrap.min.js',
	   				'dataTableTools'=> 'themes/ace-admin/js/dataTables.tableTools.min.js',
	   				'dataTablesColVis'=> 'themes/ace-admin/js/dataTables.colVis.min.js'
	   				];

	   	return $this->view('Career::division_index')->data($data)->scripts($scripts)->title('Division List');
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
        $division = $this->division->findOrFail($id);
        
        // Read ACL settings config for any permission access
        $acl = config('setting.acl');
        	               	       
		// Set data to return
	   	$data = ['row'=>$division,'acl'=>$acl];

	   	// Return data and view
	   	return $this->view('Career::division_show')->data($data)->title('View Division'); 

	}

	/**
	 * Show the form for creating new division.
	 *
	 * @return \Illuminate\View\View
	 */
	public function create()
	{
		return $this->showForm('create');
	}

	/**
	 * Handle posting of the form for creating new division.
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function store()
	{
		return $this->processForm('create');
	}

	/**
	 * Show the form for updating division.
	 *
	 * @param  int  $id
	 * @return mixed
	 */
	public function edit($id)
	{	
		return $this->showForm('update', $id);
	}

	/**
	 * Handle posting of the form for updating division.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function update($id)
	{
		return $this->processForm('update', $id);
	}

	/**
	 * Remove the specified division.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function trash($id)
	{
		if ($division = $this->division->find($id))
		{
			
			// Add deleted_at and not completely delete
			$division->delete();
			
			// Redirect with messages
			return Redirect::to(route('admin.divisions.index'))->with('success', 'Division Trashed!');
		}

		return Redirect::to(route('admin.divisions.index'))->with('error', 'Division Not Found!');
	}

	/**
	 * Restored the specified division.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function restored($id)
	{
		if ($division = $this->division->onlyTrashed()->find($id))
		{

			// Restored back from deleted_at database
			$division->restore();

			// Redirect with messages
			return Redirect::to(route('admin.divisions.index'))->with('success', 'Division Restored!');
		}

		return Redirect::to(route('admin.divisions.index'))->with('error', 'Division Not Found!');
	}
	/**
	 * Remove the specified division.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function delete($id)
	{

		// Get division from id fetch
		if ($division = $this->division->onlyTrashed()->find($id))
		{

			// Delete from pivot table many to many
			$this->division->onlyTrashed()->find($id)->roles()->detach();

			// Permanently delete
			$division->forceDelete();

			return Redirect::to(route('admin.divisions.index'))->with('success', 'Division Permanently Deleted!');
		}

		return Redirect::to(route('admin.divisions.index'))->with('error', 'Division Not Found!');
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
			if ( ! $row = $this->division->find($id))
			{
				return Redirect::to(route('admin.divisions.index'));
			}
		}
		else
		{
			$row = $this->division;
		}

		return $this->view('Career::division_form')->data(compact('mode', 'row'))->title('Division '.$mode);
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
			'name' => 'required',
			'slug'  => 'required',
			'description' => 'required'
		];

		if ($id)
		{
			$division = $this->division->find($id);

			$messages = $this->validateDivision($input, $rules);
			
			if ($messages->isEmpty())
			{
				// Get all request
				$result = $input;	

				// Slip user id
				$result = array_set($result, 'user_id', Sentinel::getUser()->id);

				$division->update($result);

			}

		}
		else
		{
			$messages = $this->validateDivision($input, $rules);

			if ($messages->isEmpty())
			{
				// Get all request
				$result = $input;	

				// Slip user id 
				$result = array_set($result, 'user_id', Sentinel::getUser()->id);

				//$menu = $this->menus->create($input);
				$division = $this->division->create($result);
				
			}
		}

		if ($messages->isEmpty())
		{
			return Redirect::to(route('admin.divisions.index'))->with('success', 'Division Updated!');
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
				$this->division->find($row)->update(['status' => Input::get('select_action')]);
		    }

		    // Set message
		    return Redirect::to(route('admin.divisions.index'))->with('success', 'Division Status Changed!');

		} else {	

		    // Set message
		    return Redirect::to(route('admin.divisions.index'))->with('error','Data not Available!');
		}
	}

	/**
	 * Validates a division.
	 *
	 * @param  array  $data
	 * @param  mixed  $id
	 * @return \Illuminate\Support\MessageBag
	 */
	protected function validateDivision($data, $rules)
	{
		$validator = Validator::make($data, $rules);

		$validator->passes();

		return $validator->errors();
	}	

	public function export() {

		// Get type file to export
		$type = Input::get('rel');
		// Get data to export
		$division = $this->division->select('id', 'divisionname', 'email', 'created_at')->get();
		// Export file to type
		Excel::create('division', function($excel) use($division) {
		    $excel->sheet('Sheet 1', function($sheet) use($division) {
		        $sheet->fromArray($division);
		    });
		})->export($type);

	}

}
