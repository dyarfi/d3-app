<?php namespace App\Modules\Participant\Controller;

// Load Laravel classes
use Route, Request, Session, Redirect, Input, Validator, View;
// Load main base controller
use App\Modules\BaseAdmin;
// Load main models
use App\Modules\Participant\Model\Image;
// Load Datatable
use Datatables;

class Images extends BaseAdmin {

	/**
	 * Set participant and images data.
	 *
	 */
	public $participants, $images;

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
		$this->images = new Image;

	}

	/**
	 * Display a listing of images.
	 *
	 * @return \Illuminate\View\View
	 */
	public function index()
	{

	   	// Set return data
	   	$images = Input::get('path') === 'trashed' ? $this->images->onlyTrashed()->paginate(4) : $this->images->orderBy('created_at','desc')->paginate(4);

	   	// Get deleted count
		$deleted = $this->images->onlyTrashed()->get()->count();

	   	// Set data to return
	   	$data = ['rows'=>$images,'deleted'=>$deleted,'junked'=>Input::get('path')];

  		// Set javascripts and stylesheets
	   	$scripts 	= [
	   		// Data Tables
			'dataTables'=> 'themes/ace-admin/js/jquery.dataTables.min.js',
			'dataTableBootstrap'=> 'themes/ace-admin/js/jquery.dataTables.bootstrap.min.js',
			'dataTableTools'=> 'themes/ace-admin/js/dataTables.tableTools.min.js',
			'dataTablesColVis'=> 'themes/ace-admin/js/dataTables.colVis.min.js',
			// ColorBox
	   		'jquery.colorbox' => asset('themes/ace-admin/js/jquery.colorbox.min.js'),
			'library' => asset("themes/ace-admin/js/library.js")

	   	];
	   	$styles 	= [
	   		'jquery.colorbox' => asset('themes/ace-admin/css/colorbox.min.css'),
	   	];

	   	return $this->view('Participant::image_index')->data($data)->scripts($scripts)->styles($styles)->title('Images List');
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
        $image = $this->images->findOrFail($id);

		// Set data to return
	   	$data = ['row'=>$image];

	   	// Return data and view
	   	return $this->view('Participant::image_show')->data($data)->title('View Image');

	}

	/**
	 * Show the form for creating new image.
	 *
	 * @return \Illuminate\View\View
	 */
	public function create()
	{
		return $this->showForm('create');
	}

	/**
	 * Handle posting of the form for creating new image.
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function store()
	{
		return $this->processForm('create');
	}

	/**
	 * Show the form for updating image.
	 *
	 * @param  int  $id
	 * @return mixed
	 */
	public function edit($id)
	{
		return $this->showForm('update', $id);
	}

	/**
	 * Handle posting of the form for updating image.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function update($id)
	{
		return $this->processForm('update', $id);
	}

	/**
	 * Remove the specified image.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function trash($id)
	{
		if ($image = $this->images->find($id))
		{

			// Add deleted_at and not completely delete
			$image->delete();

			// Redirect with messages
			return Redirect::to(route('admin.images.index'))->with('success', 'Image Trashed!');
		}

		return Redirect::to(route('admin.images.index'))->with('error', 'Image Not Found!');
	}

	/**
	 * Restored the specified image.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function restored($id)
	{
		if ($image = $this->images->onlyTrashed()->find($id))
		{

			// Restored back from deleted_at database
			$image->restore();

			// Redirect with messages
			return Redirect::to(route('admin.images.index'))->with('success', 'Image Restored!');
		}

		return Redirect::to(route('admin.images.index'))->with('error', 'Image Not Found!');
	}
	/**
	 * Remove the specified image.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function delete($id)
	{

		// Get Image from id fetch
		if ($image = $this->images->onlyTrashed()->find($id))
		{

			// Delete from pivot table many to many
			$this->images->onlyTrashed()->find($id)->participant()->detach();

			// Delete if there is an image attached
			if(File::exists('uploads/'.$image->file_name)) {
				// Delete the single file
				File::delete('uploads/'.$image->file_name);

			}

			// Permanently delete
			$image->forceDelete();

			return Redirect::to(route('admin.images.index','path=trashed'))->with('success', 'Image Permanently Deleted!');
		}

		return Redirect::to(route('admin.images.index','path=trashed'))->with('error', 'Image Not Found!');
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
			if ( ! $row = $this->images->find($id))
			{
				return Redirect::to(route('admin.images.index'));
			}
		}
		else
		{
			$row = $this->images;
		}

		return $this->view('Participant::image_form')->data(compact('mode', 'row'))->title('Image '.$mode);
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
			//$participant = Auth::getParticipantRepository()->createModel()->find($id);

			//$rules['email'] .= ",email,{$participant->email},email";

			$messages = $this->validateParticipant($input, $rules);

			if ($messages->isEmpty())
			{

				//if ( ! $participant->roles()->first() ) {

					// Syncing relationship Many To Many // Create New
					//$participant->roles()->sync(['role_id'=>$input['role_id']]);

				//} else {

					// Syncing relationship Many To Many // Update Existing
					//$participant->roles()->sync(['role_id'=>$input['role_id']]);

					// Update participant model data
					//Auth::getParticipantRepository()->update($participant, $input);

				//}

			}
		}
		else
		{

			$messages = $this->validateImage($input, $rules);

			if ($messages->isEmpty())
			{
				// Create participant into the database
				//$participant = Auth::getParticipantRepository()->create($input);

				// Syncing relationship Many To Many // Create New
				//$participant->roles()->sync(['role_id'=>$input['role_id']]);

				//$code = Activation::create($participant);

				//Activation::complete($participant, $code);
			}
		}

		if ($messages->isEmpty())
		{
			return Redirect::to(route('admin.images.show'))->with('success', 'Image Updated!');;
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
				$this->images->find($row)->update(['status' => Input::get('select_action')]);
		    }

		    // Set message
		    return Redirect::to(route('admin.images.index'))->with('success', 'Image  Status Changed!');

		} else {

		    // Set message
		    return Redirect::to(route('admin.images.index'))->with('error','Data not Available!');
		}
	}

	/**
	 * Validates a participant.
	 *
	 * @param  array  $data
	 * @param  mixed  $id
	 * @return \Illuminate\Support\MessageBag
	 */
	protected function validateImage($data, $rules)
	{
		$validator = Validator::make($data, $rules);

		$validator->passes();

		return $validator->errors();
	}

}
