<?php namespace App\Modules\Contact\Controller;

// Load Laravel classes
use Route, Request, Sentinel, Session, Redirect, Input, Validator, View;
// Load main base controller
use App\Modules\BaseAdmin;
// Load main models
use App\Modules\Contact\Model\Contact, App\Modules\User\Model\User;

class Contacts extends BaseAdmin {
	
	/**
	 * Set contacts data.
	 *
	 */
	protected $contacts;

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

		// Load contacts and get repository data from database
		$this->contacts = new Contact;

	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index() {

		// Set return data
	   	$contacts = Input::get('path') === 'trashed' ? $this->contacts->onlyTrashed()->get() : $this->contacts->orderBy('created_at','desc')->get();

	   	// Get deleted count
		$deleted = $this->contacts->onlyTrashed()->get()->count();

	   	// Set data to return
	   	$data = ['rows' => $contacts,'deleted' => $deleted,'junked' => Input::get('path')];

	   	// Load needed scripts
	   	$scripts = [
	   				'dataTables'=> 'themes/ace-admin/js/jquery.dataTables.min.js',
	   				'dataTableBootstrap'=> 'themes/ace-admin/js/jquery.dataTables.bootstrap.min.js',
	   				'dataTableTools'=> 'themes/ace-admin/js/dataTables.tableTools.min.js',
	   				'dataTablesColVis'=> 'themes/ace-admin/js/dataTables.colVis.min.js'
	   				];

		// Return data and view
	   	return $this->view('Contact::index')->data($data)->scripts($scripts)->title('Contact List');
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
        $contact = $this->contacts->find($id);

		// Set data to return
	   	$data = ['row'=>$contact];

	   	// Return data and view
	   	return $this->view('Contact::show')->data($data)->title('View Contact');

	}

	/**
	 * Show the form for creating new contact.
	 *
	 * @return \Illuminate\View\View
	 */
	public function create()
	{
		return $this->showForm('create');
	}

	/**
	 * Handle posting of the form for creating new contact.
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function store()
	{
		return $this->processForm('create');
	}

	/**
	 * Show the form for updating contact.
	 *
	 * @param  int  $id
	 * @return mixed
	 */
	public function edit($id)
	{
		return $this->showForm('update', $id);
	}

	/**
	 * Handle posting of the form for updating contact.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function update($id)
	{
		return $this->processForm('update', $id);
	}

	/**
	 * Remove the specified contact.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function trash($id)
	{
		if ($contact = $this->contacts->find($id))
		{
			// Add deleted_at and not completely delete
			$contact->delete();

			// Redirect with messages
			return Redirect::to(route('admin.contacts.index'))->with('success', 'Contact Trashed!');
		}

		return Redirect::to(route('admin.contacts.index'))->with('error', 'Contact Not Found!');
	}

	/**
	 * Restored the specified contact.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function restored($id)
	{
		if ($contact = $this->contacts->onlyTrashed()->find($id))
		{

			// Restored back from deleted_at database
			$contact->restore();

			// Redirect with messages
			return Redirect::to(route('admin.contacts.index'))->with('success', 'Contact Restored!');
		}

		return Redirect::to(route('admin.contacts.index'))->with('error', 'Contact Not Found!');;
	}

	/**
	 * Delete the specified contact.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function delete($id)
	{
		if ($contact = $this->contacts->onlyTrashed()->find($id))
		{

			// Completely delete from database
			$contact->forceDelete();

			// Redirect with messages
			return Redirect::to(route('admin.contacts.index'))->with('success', 'Contact Permanently Deleted!');
		}

		return Redirect::to(route('admin.contacts.index'))->with('error', 'Contact Not Found!');
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
			if ( ! $row = $this->contacts->find($id))
			{
				return Redirect::to(route('Contact::index'))->withErrors('Not found data!');;
			}
		}
		else
		{
			$row = $this->contacts;
		}

		return $this->view('Contact::form')->data(compact('mode', 'row'))->title('Contact '.$mode);
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
			$contact = $this->contacts->find($id);

			$messages = $this->validateContact($input, $rules);

			// checking file is valid.
		    //if ($request->file('image') && $request->file('image')->isValid()) {
			if (!empty($input['image']) && !$input['image']->getError()) {
		      $destinationPath = public_path().'/uploads'; // upload path
		      $extension = $input['image']->getClientOriginalExtension(); // getting image extension
		      $fileName = rand(11111,99999).'.'.$extension; // renameing image
		      $input['image']->move($destinationPath, $fileName); // uploading file to given path
		      // sending back with message
		      //Session::flash('success', 'Upload successfully');
		      //return Redirect::to(route('admin.contacts.create'));
		    }
		    //else {
			      // sending back with error message.
			      // Session::flash('error', 'uploaded file is not valid');
			      // return Redirect::to('contacts/'.$id.'/edit');
		    	  //$fileName = old('image') ? old('image') : $contact->image;
		    //}

			if ($messages->isEmpty())
			{
				// Get all request
				$result = $input;

				// Set user id
				$result = array_set($result, 'user_id', $this->user->id);

				// Slip image file
				$result = array_set($result, 'image', $fileName);

				$contact->update($result);
				//$contact->update($input);
			}

		}
		else
		{
			$messages = $this->validateContact($input, $rules);
			// checking file is valid.
		    if (!empty($input['image']) && !$input['image']->getError()) {
		      $destinationPath = public_path().'/uploads'; // upload path
		      $extension = $input['image']->getClientOriginalExtension(); // getting image extension
		      $fileName = rand(11111,99999).'.'.$extension; // renameing image
		      $input['image']->move($destinationPath, $fileName); // uploading file to given path
		      // sending back with message
		      //Session::flash('success', 'Upload successfully');
		      //return Redirect::to(route('admin.contacts.create'));
		    }
		    //else {
		      // sending back with error message.
		      //Session::flash('error', 'uploaded file is not valid');
		      //return Redirect::to(route('admin.contacts.create'));
		    //}

			if ($messages->isEmpty())
			{
				// Get all request
				$result = $input;

				// Set user id
				$result = array_set($result, 'user_id', $this->user->id);

				// Slip image file
				$result = is_array($result['image']) ? array_set($result, 'image', '') : array_set($result, 'image', $fileName);

				//$contact = $this->contacts->create($input);
				$contact = $this->contacts->create($result);

			}
		}

		if ($messages->isEmpty())
		{
			return Redirect::to(route('admin.contacts.show', $contact->id))->with('success', 'Contact Updated!');
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
				$this->contacts->find($row)->update(['status' => Input::get('select_action')]);
		    }

		    // Set message
		    return Redirect::to(route('admin.contacts.index'))->with('success', 'Contact Status Changed!');

		} else {

		    // Set message
		    return Redirect::to(route('admin.contacts.index'))->with('error','Data not Available!');
		}
	}

	/**
	 * Validates a contact.
	 *
	 * @param  array  $data
	 * @param  mixed  $id
	 * @return \Illuminate\Support\MessageBag
	 */
	protected function validateContact($data, $rules)
	{
		$validator = Validator::make($data, $rules);

		$validator->passes();

		return $validator->errors();
	}


}
