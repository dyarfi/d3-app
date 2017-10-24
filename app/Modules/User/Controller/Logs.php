<?php namespace App\Modules\User\Controller;

// Load Laravel classes
use Route, Request, Session, Redirect, Input, Validator, Excel, View;
// Load Auth and Socialite classes
use Sentinel;
// Load main base controller
use App\Modules\BaseAdmin;
// Load main models
use App\Modules\User\Model\Log;
// User Activity Logs
use Activity;

class Logs extends BaseAdmin {

	/**
	 * Holds the Sentinel Logs repository.
	 *
	 * @var \Cartalyst\Sentinel\Logs\EloquentLog
	 */
	protected $logs;

	/**
	 * Constructor.
	 *
	 * @return void
	 */
	public function __construct()
	{
		
		// Parent constructor
		parent::__construct();
		
		// Load Http/Middleware/Admin controller
		$this->middleware('auth.admin');

		// Load logs and create model from Auth
		$this->logs = new Log;
		
	}

	/**
	 * Display a listing of logs.
	 *
	 * @return \Illuminate\View\View
	 */
	public function index()
	{

		// Set return data 
	   	$rows = Input::get('path') === 'trashed' ? Log::onlyTrashed()->orderBy('created_at', 'desc')->paginate(15) : Log::with('user')->orderBy('created_at', 'desc')->paginate(15);
	   	
	   	// Get deleted count
		$deleted = Log::onlyTrashed()->get()->count();

		// Get trashed mode
		$junked  = Input::get('path');

		return $this->view('User::sentinel.logs.index')->data(compact('rows','deleted','junked'))->title('Logs Listing');
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
        $log = $this->logs->with('user')->findOrFail($id);
        
        // Set data to return
	   	$data = ['row'=>$log];

	   	// Return data and view
	   	return $this->view('User::sentinel.logs.show')->data($data)->title('View Log'); 

	}

	/**
	 * Show the form for creating new log.
	 *
	 * @return \Illuminate\View\View
	 */
	public function create()
	{
		return $this->showForm('create');
	}

	/**
	 * Handle posting of the form for creating new log.
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function store()
	{
		return $this->processForm('create');
	}

	/**
	 * Show the form for updating log.
	 *
	 * @param  int  $id
	 * @return mixed
	 */
	public function edit($id)
	{					
		return $this->showForm('update', $id);
	}

	/**
	 * Handle posting of the form for updating log.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function update($id)
	{
		return $this->processForm('update', $id);
	}
	
	/**
	 * Remove the specified log.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function trash($id)
	{
		if ($log = Log::find($id))
		{

			// Add deleted_at and not completely delete
			$log->delete();

			// Redirect with messages
			return Redirect::to(route('admin.logs.index'))->with('success', 'Log Trashed!');
		}

		return Redirect::to(route('admin.logs.index'))->with('error', 'Log Not Found!');;
	}

	/**
	 * Restored the specified setting.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function restored($id)
	{
		if ($log = Log::onlyTrashed()->find($id))
		{

			// Restored back from deleted_at database
			$log->restore();

			// Redirect with messages
			return Redirect::to(route('admin.logs.index'))->with('success', 'Log Restored!');
		}

		return Redirect::to(route('admin.logs.index'))->with('error', 'Log Not Found!');
	}

	/**
	 * Remove the specified log.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function delete($id)
	{
		if ($log = Log::onlyTrashed()->find($id))
		{

			// Completely delete from database
			$log->forceDelete();

			// Redirect with messages
			return Redirect::to(route('admin.logs.index'))->with('success', 'Log Permanently Deleted!');

		}

		return Redirect::to(route('admin.logs.index'))->with('error', 'Log Not Found!');;
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
			if ( ! $log = $this->logs->find($id))
			{
				return Redirect::to(route('admin.logs.index'));
			}
		}
		else
		{
			$log = $this->logs;
		}

		
		$log_access = config('setting.modules');
		
		$log = Sentinel::findLogById($this->user->logs()->first()->id);

		//dd (array_keys($log_access));

		// dd ($log->hasAccess('tasks'));
		
		return $this->view('User::sentinel.logs.form')->data(compact('mode', 'log'))->title('Logs '.$mode);
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
		$input = Input::all();	 

		if ($input['permissions'] === 'true') {

			$input['permissions'] = ['admin'=>true];

		} else {

			$input['permissions'] = ['admin'=>false];

		}

		$rules = [
			'name' => 'required',
			'slug' => 'required|unique:logs'
		];
		
		if ($id)
		{

			$log = $this->logs->find($id);

			$rules['slug'] .= ",slug,{$log->slug},slug";

			$messages = $this->validateLog($input, $rules);

			if ($messages->isEmpty())
			{
				$log->fill($input);

				$log->save();
			}
		}
		else
		{

			$messages = $this->validateLog($input, $rules);

			if ($messages->isEmpty())
			{	

				$log = $this->logs->create($input);				

			}
		}

		if ($messages->isEmpty())
		{
			return Redirect::to(route('admin.logs.index'))->with('success', 'Log Updated!');;
		}

		return Redirect::back()->withInput()->withErrors($messages);
	}

	/**
	 * Validates a log.
	 *
	 * @param  array  $data
	 * @param  mixed  $id
	 * @return \Illuminate\Support\MessageBag
	 */
	protected function validateLog($data, $rules)
	{
		$validator = Validator::make($data, $rules);

		$validator->passes();

		return $validator->errors();
	}

	/**
	 * Process a file generated headers for logs tables.
	 *
	 * @param  void
	 * @return header .xls
	 */
	public function export() {
		// Get type file to export
		$type = Input::get('rel');
		// Get data to export
		$logs = $this->logs->select('id', 'user_id', 'description','created_at')->get();
		// Export file to type
		Excel::create('logs', function($excel) use($logs) {
			// Set the spreadsheet title, creator, and description
	        $excel->setTitle('Export List');
	        $excel->setCreator('Laravel')->setCompany('laravel.com');
	        $excel->setDescription('export file');

		    $excel->sheet('Sheet 1', function($sheet) use($logs) {
		        $sheet->fromArray($logs);
		    });
		})->export($type);
	}


}
