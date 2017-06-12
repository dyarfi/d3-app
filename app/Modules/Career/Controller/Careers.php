<?php namespace App\Modules\Career\Controller;

// Load Laravel classes
use Route, Request, Sentinel, Session, Redirect, Input, Image, Validator, View;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
// Load main base controller
use App\Modules\BaseAdmin;
// Load main models
use App\Modules\Career\Model\Career;
use App\Modules\Career\Model\Division;
use App\Modules\Career\Model\Applicant;

class Careers extends BaseAdmin {

	/**
	 * Holds the Sentinel Users repository.
	 *
	 * @var \Cartalyst\Sentinel\Users\EloquentUser
	 */
	protected $careers;

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		//dd(storage_path());

		// Parent constructor
		parent::__construct();

		// Load Http/Middleware/Admin controller
		$this->middleware('auth.admin');

		// Load careers and get repository data from database
		$this->careers = new Career;
		$this->divisions = new Division;

	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index() {

		// Set return data
	   	$careers = Input::get('path') === 'trashed' ? $this->careers->onlyTrashed()->get() : $this->careers->orderBy('created_at','desc')->get();

	   	// Get deleted count
		$deleted = $this->careers->onlyTrashed()->get()->count();

	   	// Set data to return
	   	$data = ['rows' => $careers,'deleted' => $deleted,'junked' => Input::get('path')];

		// Load needed scripts
	   	$scripts = [
	   				'dataTables'=> 'themes/ace-admin/js/jquery.dataTables.min.js',
	   				'dataTableBootstrap'=> 'themes/ace-admin/js/jquery.dataTables.bootstrap.min.js',
	   				'dataTableTools'=> 'themes/ace-admin/js/dataTables.tableTools.min.js',
	   				'dataTablesColVis'=> 'themes/ace-admin/js/dataTables.colVis.min.js'
	   				];

		// Return data and view
	   	return $this->view('Career::career_index')->data($data)->scripts($scripts)->title('Career List');
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
        $career = $this->careers->find($id);

		// Set data to return
	   	$data = ['row'=>$career];

	   	// Return data and view
	   	return $this->view('Career::career_show')->data($data)->title('View Career');

	}

	/**
	 * Show the form for creating new career.
	 *
	 * @return \Illuminate\View\View
	 */
	public function create()
	{
		return $this->showForm('create');
	}

	/**
	 * Handle posting of the form for creating new career.
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function store()
	{
		return $this->processForm('create');
	}

	/**
	 * Show the form for updating career.
	 *
	 * @param  int  $id
	 * @return mixed
	 */
	public function edit($id)
	{
		return $this->showForm('update', $id);
	}

	/**
	 * Handle posting of the form for updating career.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function update($id)
	{
		return $this->processForm('update', $id);
	}

	/**
	 * Remove the specified career.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function trash($id)
	{
		if ($career = $this->careers->find($id))
		{
			// Add deleted_at and not completely delete
			$career->delete();

			// Redirect with messages
			return Redirect::to(route('admin.careers.index'))->with('success', 'Career Trashed!');
		}

		return Redirect::to(route('admin.careers.index'))->with('error', 'Career Not Found!');
	}

	/**
	 * Restored the specified career.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function restored($id)
	{
		if ($career = $this->careers->onlyTrashed()->find($id))
		{

			// Restored back from deleted_at database
			$career->restore();

			// Redirect with messages
			return Redirect::to(route('admin.careers.index'))->with('success', 'Career Restored!');
		}

		return Redirect::to(route('admin.careers.index'))->with('error', 'Career Not Found!');;
	}

	/**
	 * Delete the specified career.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function delete($id)
	{
		if ($career = $this->careers->onlyTrashed()->find($id))
		{

			// Completely delete from database
			$career->forceDelete();

			// Redirect with messages
			return Redirect::to(route('admin.careers.index'))->with('success', 'Career Permanently Deleted!');
		}

		return Redirect::to(route('admin.careers.index'))->with('error', 'Career Not Found!');
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
			if ( ! $row = $this->careers->find($id))
			{
				return Redirect::to(route('admin.careers.index'))->withErrors('Not found data!');;
			}
		}
		else
		{
			$row = $this->careers;
		}

		// Set division model to name and id only for lookup input
		$divisions = $this->divisions->lists('name', 'id')->all();

	   	// Load needed javascripts
	   	$scripts = ['bootstrap-datepicker'=> 'themes/ace-admin/js/bootstrap-datepicker.min.js'];

		// Load needed stylesheets
	   	$styles = ['stylesheet'=> 'themes/ace-admin/css/datepicker.min.css'];

		return $this->view('Career::career_form')->data(compact('mode', 'row', 'divisions'))->scripts($scripts)->styles($styles)->title('Career '.$mode);
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
			'division_id'  => 'required',
		    'end_date' 	   => 'date_format:Y-m-d|required',
			'status'	   => 'boolean'
		];

		if ($id)
		{
			$career = $this->careers->find($id);

			$messages = $this->validateCareer($input, $rules);

			// checking file is valid.
		    //if ($request->file('image') && $request->file('image')->isValid()) {
			if (!empty($input['image']) && !$input['image']->getError()) {
		      	$destinationPath = public_path().'/uploads'; // upload path
	      		$extension = $input['image']->getClientOriginalExtension(); // getting image extension
		      	$fileName = rand(11111,99999).'.'.$extension; // renaming image
		      	$input['image']->move($destinationPath, $fileName); // uploading file to given path

				/*
				$imagePath = $request->file('image')->store('public');
			    $image = Image::make(Storage::get($imagePath))->resize(320,240)->encode();
			    Storage::put($imagePath,$image);

			    $imagePath = explode('/',$imagePath);

			    $imagePath = $imagePath[1];

			    $myTheory->image = $imagePath;
				*/
		      	//Storage::disk('local')->put('public/'.$fileName, File::get($input['image']));
		      	//Storage::disk('local')->put($fileName,  File::get( $input['image'] ));
		      	// sending back with message
		      	//Session::flash('success', 'Upload successfully');
		      	//return Redirect::to(route('admin.apanel.careers.create'));
		    }
		    else {
			      // sending back with error message.
			      // Session::flash('error', 'uploaded file is not valid');
			      // return Redirect::to('careers/'.$id.'/edit');
		    	  $fileName = old('image') ? old('image') : $career->image;
		    }

			if ($messages->isEmpty())
			{
				// Get all request
				$result = $input;

				// Set user id
				$result['user_id'] = $this->user->id;

				// Slip image file
				$result = array_set($result, 'image', $fileName);

				$career->update($result);
			}

		}
		else
		{
			$messages = $this->validateCareer($input, $rules);
			// checking file is valid.
		    if (!empty($input['image']) && !$input['image']->getError()) {
		      $destinationPath = public_path().'/uploads'; // upload path
		      $extension = $input['image']->getClientOriginalExtension(); // getting image extension
		      $fileName = rand(11111,99999).'.'.$extension; // renameing image
		      $input['image']->move($destinationPath, $fileName); // uploading file to given path
		      // sending back with message
		      //Session::flash('success', 'Upload successfully');
		      //return Redirect::to(route('admin.apanel.careers.create'));
		    }
		    //else {
		      // sending back with error message.
		      //Session::flash('error', 'uploaded file is not valid');
		      //return Redirect::to(route('admin.careers.create'));
		    //}

			if ($messages->isEmpty())
			{
				// Get all request
				$result = $input;

				// Set user id
				$result['user_id'] = $this->user->id;

				// Slip image file
				$result = is_array(@$result['image']) ? array_set($result, 'image', '') : array_set($result, 'image', @$fileName);

				//$career = $this->careers->create($input);
				$career = $this->careers->create($result);

			}
		}

		if ($messages->isEmpty())
		{
			return Redirect::to(route('admin.careers.show', $career->id))->with('success', 'Career Updated!');
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
				$this->careers->find($row)->update(['status' => Input::get('select_action')]);
		    }

		    // Set message
		    return Redirect::to(route('admin.careers.index'))->with('success', 'Career Status Changed!');

		} else {

		    // Set message
		    return Redirect::to(route('admin.careers.index'))->with('error','Data not Available!');
		}
	}

	/**
	 * Validates a career.
	 *
	 * @param  array  $data
	 * @param  mixed  $id
	 * @return \Illuminate\Support\MessageBag
	 */
	protected function validateCareer($data, $rules)
	{
		$validator = Validator::make($data, $rules);

		$validator->passes();

		return $validator->errors();
	}


}
