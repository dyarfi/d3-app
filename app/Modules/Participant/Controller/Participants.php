<?php namespace App\Modules\Participant\Controller;

// Load Laravel classes
use Route, Request, Session, Redirect, Auth, Activation, Socialite, Input, Validator, View;
// Load main base controller
use App\Modules\BaseAdmin;
// Load main models
use App\Modules\Participant\Model\Participant;

class Participants extends BaseAdmin {

	/**
	 * Holds the Sentinel Participants repository.
	 *
	 * @var \Cartalyst\Sentinel\Participants\EloquentParticipant
	 */
	public $participants;

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

		// Load participants and get repository data from Auth
		$this->participants = new Participant;

	}

	/**
	 * Display a listing of participants.
	 *
	 * @return \Illuminate\View\View
	 */
	public function index()
	{

		// Set return data 
	   	$participants = Input::get('path') === 'trashed' ? $this->participants->onlyTrashed()->paginate(4) : $this->participants->orderBy('created_at','desc')->paginate(4);

	   	// Get deleted count
		$deleted = $this->participants->onlyTrashed()->get()->count();
	   	
	   	// Set data to return
	   	$data = ['rows'=>$participants,'deleted'=>$deleted,'junked'=>Input::get('path')];

  		// Load needed scripts
	   	$scripts = [
	   				'dataTables'=> 'themes/ace-admin/js/jquery.dataTables.min.js',
	   				'dataTableBootstrap'=> 'themes/ace-admin/js/jquery.dataTables.bootstrap.min.js',
	   				'dataTableTools'=> 'themes/ace-admin/js/dataTables.tableTools.min.js',
	   				'dataTablesColVis'=> 'themes/ace-admin/js/dataTables.colVis.min.js'
	   				];

	   	return $this->view('Participant::participant_index')->data($data)->scripts($scripts)->title('Participants List');
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
        $participant = $this->participants->findOrFail($id);

		// Set data to return
	   	$data = ['row'=>$participant];

	   	// Return data and view
	   	return $this->view('Participant::participant_show')->data($data)->title('View Participant'); 

	}

	/**
	 * Show the form for creating new participant.
	 *
	 * @return \Illuminate\View\View
	 */
	public function create()
	{
		return $this->showForm('create');
	}

	/**
	 * Handle posting of the form for creating new participant.
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function store()
	{
		return $this->processForm('create');
	}

	/**
	 * Show the form for updating participant.
	 *
	 * @param  int  $id
	 * @return mixed
	 */
	public function edit($id)
	{	
		return $this->showForm('update', $id);
	}

	/**
	 * Handle posting of the form for updating participant.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function update($id)
	{
		return $this->processForm('update', $id);
	}

	/**
	 * Remove the specified participant.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function trash($id)
	{
		if ($participant = $this->participants->find($id))
		{
			
			// Add deleted_at and not completely delete
			$participant->delete();
			
			// Redirect with messages
			return Redirect::to(route('admin.participants.index'))->with('success', 'Participant Trashed!');
		}

		return Redirect::to(route('admin.participants.index'))->with('error', 'Participant Not Found!');
	}

	/**
	 * Restored the specified participant.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function restored($id)
	{
		if ($participant = $this->participants->onlyTrashed()->find($id))
		{

			// Restored back from deleted_at database
			$participant->restore();

			// Redirect with messages
			return Redirect::to(route('admin.participants.index'))->with('success', 'Participant Restored!');
		}

		return Redirect::to(route('admin.participants.index'))->with('error', 'Participant Not Found!');
	}
	/**
	 * Remove the specified participant.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function delete($id)
	{

		// Get participant from id fetch
		if ($participant = $this->participants->onlyTrashed()->find($id))
		{

			// Delete from pivot table many to many
			$this->participants->onlyTrashed()->find($id)->roles()->detach();

			// Permanently delete
			$participant->forceDelete();

			return Redirect::to(route('admin.participants.index'))->with('success', 'Participant Permanently Deleted!');
		}

		return Redirect::to(route('admin.participants.index'))->with('error', 'Participant Not Found!');
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
			if ( ! $row = $this->participants->find($id))
			{
				return Redirect::to(route('admin.participants.index'));
			}
		}
		else
		{
			$row = $this->participants;
		}
		
		return $this->view('Participant::participant_form')->data(compact('mode', 'row'))->title('Participant '.$mode);
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
			'first_name' => 'required',
			'last_name'  => 'required',
			'role_id'  	 => 'required',			
			'email'      => 'required|unique:participants'
		];
		
		if ($id)
		{
			$participant = Sentinel::getParticipantRepository()->createModel()->find($id);

			$rules['email'] .= ",email,{$participant->email},email";

			$messages = $this->validateParticipant($input, $rules);

			if ($messages->isEmpty())
			{

				if ( ! $participant->roles()->first() ) {
					
					// Syncing relationship Many To Many // Create New
					$participant->roles()->sync(['role_id'=>$input['role_id']]);
					
				} else {

					// Syncing relationship Many To Many // Update Existing
					$participant->roles()->sync(['role_id'=>$input['role_id']]);
					
					// Update participant model data
					Sentinel::getParticipantRepository()->update($participant, $input);

				}
				
			}
		}
		else
		{
			
			$messages = $this->validateParticipant($input, $rules);

			if ($messages->isEmpty())
			{
				// Create participant into the database
				$participant = Sentinel::getParticipantRepository()->create($input);
				
				// Syncing relationship Many To Many // Create New
				$participant->roles()->sync(['role_id'=>$input['role_id']]);

				$code = Activation::create($participant);

				Activation::complete($participant, $code);
			}
		}

		if ($messages->isEmpty())
		{
			return Redirect::to(route('admin.participants.index'))->with('success', 'Participant Updated!');;
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
				$this->participants->find($row)->update(['status' => Input::get('select_action')]);
		    }

		    // Set message
		    return Redirect::to(route('admin.participants.index'))->with('success', 'Participant  Status Changed!');

		} else {	

		    // Set message
		    return Redirect::to(route('admin.participants.index'))->with('error','Data not Available!');
		}
	}

	/**
	 * Validates a participant.
	 *
	 * @param  array  $data
	 * @param  mixed  $id
	 * @return \Illuminate\Support\MessageBag
	 */
	protected function validateParticipant($data, $rules)
	{
		$validator = Validator::make($data, $rules);

		$validator->passes();

		return $validator->errors();
	}

}
