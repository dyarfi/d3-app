<?php namespace App\Modules\Task\Controller;

// Load Laravel classes
use Route, Request, Sentinel, Session, Redirect, Input, Validator, View, File;
// Load main base controller
use App\Modules\BaseAdmin;
// Load main models
use App\Modules\Task\Model\Task, App\Modules\User\Model\User;
// MediaAble Uploader
use MediaUploader;
// User Activity Logs
use Activity;

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
	   				'dataTables'=> asset('themes/ace-admin/js/jquery.dataTables.min.js'),
	   				'dataTableBootstrap'=> asset('themes/ace-admin/js/jquery.dataTables.bootstrap.min.js'),
	   				'dataTableTools'=> asset('themes/ace-admin/js/dataTables.tableTools.min.js'),
	   				'dataTablesColVis'=> asset('themes/ace-admin/js/dataTables.colVis.min.js'),
					'library' => asset('themes/ace-admin/js/library.js')
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

			// Log it first
			Activity::log(__FUNCTION__);

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

			// Log it first
			Activity::log(__FUNCTION__);

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

			// Log it first
			Activity::log(__FUNCTION__);			

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
		
		// Load needed javascripts
		$scripts = [
			'bootstrap-tag'=>asset("themes/ace-admin/js/bootstrap-tag.min.js"),
			'bootstrap-datepicker'=>asset('themes/ace-admin/js/bootstrap-datepicker.min.js'),
			'ckeditor'=>asset('themes/ace-admin/plugins/ckeditor/ckeditor.js'),
			'library'=>asset('themes/ace-admin/js/library.js')
		];

		return $this->view('Task::form')->data(compact('mode', 'row'))->scripts($scripts)->title('Task '.$mode);
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
		// Set mediaable uploader
		$media = '';
		//dd($input);

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


			// If user upload a file
			if (isset($input['image']) && Input::hasFile('image')) {

				// Set filename
				// $filename = $this->imageUploadToDb($input['image'], 'uploads', 'task_');
				$media = MediaUploader::fromSource($input['image'])->upload();

			}

			if ($messages->isEmpty())
			{
				// Get all request
				$result = $input;

				// Set user id
				$result = array_set($result, 'user_id', $this->user->id);

				// Slip image file
				$result = isset($filename) ? array_set($input, 'image', $filename) : $result;

				// Update data
				$task->update($result);

				// Sync mediaable data
				if($media) $task->syncMedia($media, 'featured');

			}

		}
		else
		{
			$messages = $this->validateTask($input, $rules);

			// If user upload a file
			if (isset($input['image']) && Input::hasFile('image')) {

				// Set filename
				// $filename = $this->imageUploadToDb($input['image'], 'uploads', 'task_');
				$media = MediaUploader::fromSource($input['image'])->upload();

			}

			if ($messages->isEmpty())
			{
				// Get all request
				$result = $input;

				// Set user id
				$result = array_set($result, 'user_id', $this->user->id);

				// Slip image file
				$result = isset($input['image']) ? array_set($result, 'image', @$filename) : array_set($result, 'image', '');

				// Create data
				$task = $this->tasks->create($result);

				// Attach mediaable data
				if ($media) $task->attachMedia($media, 'featured');

			}
		}

		// Log it first
		Activity::log(__FUNCTION__);

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

		// Log it first
		Activity::log(__FUNCTION__);

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
	 * Process a file upload save the filename to DB.
	 *
	 * @param  array  $file
	 * @param  string $path
	 * @param  string $type
	 * @return string $filename
	 */
 	protected function imageUploadToDb($file='', $path='', $type='')
    	{
   	 	// Set filename upload
   	 	$filename = '';
   	 	// Check if input and upload already assigned
   	 	if (!empty($file) && !$file->getError()) {
   	 		// Getting image extension
   	 		$extension = $file->getClientOriginalExtension();
   	 		// Renaming image
   	 		$filename = $type . rand(11111,99999) . '.' . $extension;
   	 		// Set intervention image for image manipulation
   	 		Storage::disk('local_uploads')->put($filename,
   	 			file_get_contents($file->getRealPath())
   	 		);
   	 		// If image has a resize crop data in constructor
   	 		if (!empty($this->imgFit)) {
   	 			$image = Image::make($path .'/'. $filename);
   	 			foreach ($this->imgFit as $imgFit) {
   	 				$size = explode('x',$imgFit);
   	 				$image->fit($size[0],$size[1])->save($path .'/'. $imgFit.'px_'. $filename);
   	 			}
   	 		}
   	 	}
   	 	return $filename;
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
