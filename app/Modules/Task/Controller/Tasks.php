<?php namespace App\Modules\Task\Controller;

// Load Laravel classes
use Route, Request, Sentinel, Session, Redirect, Input, Validator, View;
// Load main base controller
use App\Modules\BaseAdmin;
// Load main models
use App\Modules\Task\Model\Task, App\Modules\User\Model\User;

class Tasks extends BaseAdmin {
	/**
	 * Set tasks data.
	 *
	 */
	protected $tasks;

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

		// Load tasks and get repository data from database
		$this->tasks = new Task;

	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index() {

		// Set return data
	   	$tasks = Input::get('path') === 'trashed' ? $this->tasks->onlyTrashed()->get() : $this->tasks->orderBy('created_at','desc')->get();

	   	// Get deleted count
		$deleted = $this->tasks->onlyTrashed()->get()->count();

	   	// Set data to return
	   	$data = ['rows' => $tasks,'deleted' => $deleted,'junked' => Input::get('path')];

	   	// Load needed scripts
	   	$scripts = [
	   				'dataTables'=> 'themes/ace-admin/js/jquery.dataTables.min.js',
	   				'dataTableBootstrap'=> 'themes/ace-admin/js/jquery.dataTables.bootstrap.min.js',
	   				'dataTableTools'=> 'themes/ace-admin/js/dataTables.tableTools.min.js',
	   				'dataTablesColVis'=> 'themes/ace-admin/js/dataTables.colVis.min.js'
	   				];

		// Return data and view
	   	return $this->view('Task::index')->data($data)->scripts($scripts)->title('Task List');
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
        $task = $this->tasks->find($id);

		// Set data to return
	   	$data = ['row'=>$task];

	   	// Return data and view
	   	return $this->view('Task::show')->data($data)->title('View Task');

	}

	/**
	 * Show the form for creating new task.
	 *
	 * @return \Illuminate\View\View
	 */
	public function create()
	{
		return $this->showForm('create');
	}

	/**
	 * Handle posting of the form for creating new task.
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function store()
	{
		return $this->processForm('create');
	}

	/**
	 * Show the form for updating task.
	 *
	 * @param  int  $id
	 * @return mixed
	 */
	public function edit($id)
	{
		return $this->showForm('update', $id);
	}

	/**
	 * Handle posting of the form for updating task.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function update($id)
	{
		return $this->processForm('update', $id);
	}

	/**
	 * Remove the specified task.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function trash($id)
	{
		if ($task = $this->tasks->find($id))
		{
			// Add deleted_at and not completely delete
			$task->delete();

			// Redirect with messages
			return Redirect::to(route('admin.tasks.index'))->with('success', 'Task Trashed!');
		}

		return Redirect::to(route('admin.tasks.index'))->with('error', 'Task Not Found!');
	}

	/**
	 * Restored the specified task.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function restored($id)
	{
		if ($task = $this->tasks->onlyTrashed()->find($id))
		{

			// Restored back from deleted_at database
			$task->restore();

			// Redirect with messages
			return Redirect::to(route('admin.tasks.index'))->with('success', 'Task Restored!');
		}

		return Redirect::to(route('admin.tasks.index'))->with('error', 'Task Not Found!');;
	}

	/**
	 * Delete the specified task.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function delete($id)
	{
		if ($task = $this->tasks->onlyTrashed()->find($id))
		{

			// Delete if there is an image attached
			if(File::exists('uploads/'.$task->image)) {
				// Delete the single file
				File::delete('uploads/'.$task->image);

			}

			// Completely delete from database
			$task->forceDelete();

			// Redirect with messages
			return Redirect::to(route('admin.tasks.index','path=trashed'))->with('success', 'Task Permanently Deleted!');
		}

		return Redirect::to(route('admin.tasks.index','path=trashed'))->with('error', 'Task Not Found!');
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
			if ( ! $row = $this->tasks->find($id))
			{
				return Redirect::to(route('Task::index'))->withErrors('Not found data!');;
			}
		}
		else
		{
			$row = $this->tasks;
		}

		return $this->view('Task::form')->data(compact('mode', 'row'))->title('Task '.$mode);
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
		//$request = new Request;

		$input = array_filter(Input::all());
		//$input = $request;
		//print_r($input);
		//exit;
		//$input['slug'] = isset($input['title']) ? snake_case($input['title']) : '';

		//$request = $input;

		$rules = [
			'title' 	   => 'required',
			'slug' 		   => 'required',
			'description'  => 'required',
			'image' 	   => 'image|mimes:jpg,jpeg,png|max:500kb',
			'status'	   => 'boolean'
		];

		if ($id)
		{
			$task = $this->tasks->find($id);

			$messages = $this->validateTask($input, $rules);

			// checking file is valid.
		    //if ($request->file('image') && $request->file('image')->isValid()) {
			if (!empty($input['image']) && !$input['image']->getError()) {
		      $destinationPath = public_path().'/uploads'; // upload path
		      $extension = $input['image']->getClientOriginalExtension(); // getting image extension
		      $fileName = rand(11111,99999).'.'.$extension; // renameing image
		      $input['image']->move($destinationPath, $fileName); // uploading file to given path
		      // sending back with message
		      //Session::flash('success', 'Upload successfully');
		      //return Redirect::to(route('admin.tasks.create'));
		    }
		    //else {
			      // sending back with error message.
			      // Session::flash('error', 'uploaded file is not valid');
			      // return Redirect::to('tasks/'.$id.'/edit');
		    	  //$fileName = old('image') ? old('image') : $task->image;
		    //}

			if ($messages->isEmpty())
			{
				// Get all request
				$result = $input;

				// Set user id
				$result = array_set($result, 'user_id', $this->user->id);

				// Slip image file
				$result = array_set($result, 'image', $fileName);

				$task->update($result);
				//$task->update($input);
			}

		}
		else
		{
			$messages = $this->validateTask($input, $rules);
			// checking file is valid.
		    if (!empty($input['image']) && !$input['image']->getError()) {
		      $destinationPath = public_path().'/uploads'; // upload path
		      $extension = $input['image']->getClientOriginalExtension(); // getting image extension
		      $fileName = rand(11111,99999).'.'.$extension; // renameing image
		      $input['image']->move($destinationPath, $fileName); // uploading file to given path
		      // sending back with message
		      //Session::flash('success', 'Upload successfully');
		      //return Redirect::to(route('admin.tasks.create'));
		    }
		    //else {
		      // sending back with error message.
		      //Session::flash('error', 'uploaded file is not valid');
		      //return Redirect::to(route('admin.tasks.create'));
		    //}

			if ($messages->isEmpty())
			{
				// Get all request
				$result = $input;

				// Set user id
				$result = array_set($result, 'user_id', $this->user->id);

				// Slip image file
				$result = is_array($result['image']) ? array_set($result, 'image', '') : array_set($result, 'image', $fileName);

				//$task = $this->tasks->create($input);
				$task = $this->tasks->create($result);

			}
		}

		if ($messages->isEmpty())
		{
			return Redirect::to(route('admin.tasks.show', $task->id))->with('success', 'Task Updated!');
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
				$this->tasks->find($row)->update(['status' => Input::get('select_action')]);
		    }

		    // Set message
		    return Redirect::to(route('admin.tasks.index'))->with('success', 'Task Status Changed!');

		} else {

		    // Set message
		    return Redirect::to(route('admin.tasks.index'))->with('error','Data not Available!');
		}
	}

	/**
	 * Validates a task.
	 *
	 * @param  array  $data
	 * @param  mixed  $id
	 * @return \Illuminate\Support\MessageBag
	 */
	protected function validateTask($data, $rules)
	{
		$validator = Validator::make($data, $rules);

		$validator->passes();

		return $validator->errors();
	}


}
