<?php namespace App\Modules\Career\Controller;

// Load Laravel classes
use Route, Request, Session, Redirect, Input, Validator, View, Excel, File;
// Load main base controller
use App\Modules\BaseAdmin;
// Load main models
use App\Modules\Career\Model\Career,
	App\Modules\Career\Model\Applicant;
// Load Datatable
use Datatables;
// User Activity Logs
use Activity;

class Applicants extends BaseAdmin {

	/**
	 * Set applicants data.
	 *
	 */
	protected $applicants;

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
		$this->middleware('auth.admin',['except'=>'profile']);

		// Load applicants and get repository data from Auth
		$this->applicants = new Applicant;


	}

	/**
	 * Display a listing of applicants.
	 *
	 * @return \Illuminate\View\View
	 */
	public function index()
	{

		// Set return data
	   	$applicants = Input::get('path') === 'trashed' ? $this->applicants->with('career')->onlyTrashed()->get() : $this->applicants->with('career')->orderBy('created_at','desc')->get();

		// Get deleted count
		$deleted = $this->applicants->with('career')->onlyTrashed()->get()->count();

	   	// Set data to return
	   	$data = ['rows'=>$applicants,'deleted'=>$deleted,'junked'=>Input::get('path')];

   		// Load needed scripts
	   	$scripts = [
	   				'dataTables'=> 'themes/ace-admin/js/jquery.dataTables.min.js',
	   				'dataTableBootstrap'=> 'themes/ace-admin/js/jquery.dataTables.bootstrap.min.js',
	   				'dataTableTools'=> 'themes/ace-admin/js/dataTables.tableTools.min.js',
	   				'dataTablesColVis'=> 'themes/ace-admin/js/dataTables.colVis.min.js',
	   				// Load needed javascripts
					'library' => asset('themes/ace-admin/js/library.js')
	   				];

	   	return $this->view('Career::applicant_index')->data($data)->scripts($scripts)->title('Applicants List');
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
        $applicant = $this->applicants->findOrFail($id);

        // Read ACL settings config for any permission access
        $acl = config('setting.modules');

		// Set data to return
	   	$data = ['row'=>$applicant,'acl'=>$acl];

	   	// Return data and view
	   	return $this->view('Career::applicant_show')->data($data)->title('View Applicant');

	}

	/**
	 * Show the form for creating new applicant.
	 *
	 * @return \Illuminate\View\View
	 */
	public function create()
	{
		return $this->showForm('create');
	}

	/**
	 * Handle posting of the form for creating new applicant.
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function store()
	{
		return $this->processForm('create');
	}

	/**
	 * Show the form for updating applicant.
	 *
	 * @param  int  $id
	 * @return mixed
	 */
	public function edit($id)
	{
		return $this->showForm('update', $id);
	}

	/**
	 * Handle posting of the form for updating applicant.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function update($id)
	{
		return $this->processForm('update', $id);
	}

	/**
	 * Remove the specified applicant.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function trash($id)
	{
		if ($applicant = $this->applicants->find($id))
		{

			// Add deleted_at and not completely delete
			$applicant->delete();

			// Log it first
			Activity::log(__FUNCTION__);

			// Redirect with messages
			return Redirect::to(route('admin.applicants.index'))->with('success', 'Applicant Trashed!');
		}

		return Redirect::to(route('admin.applicants.index'))->with('error', 'Applicant Not Found!');
	}

	/**
	 * Restored the specified applicant.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function restored($id)
	{
		if ($applicant = $this->applicants->onlyTrashed()->find($id))
		{

			// Restored back from deleted_at database
			$applicant->restore();

			// Log it first
			Activity::log(__FUNCTION__);

			// Redirect with messages
			return Redirect::to(route('admin.applicants.index'))->with('success', 'Applicant Restored!');
		}

		return Redirect::to(route('admin.applicants.index'))->with('error', 'Applicant Not Found!');
	}
	/**
	 * Remove the specified applicant.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function delete($id)
	{

		// Get applicant from id fetch
		if ($applicant = $this->applicants->onlyTrashed()->find($id))
		{

			// Delete if there is an image attached
			if(File::exists('uploads/'.$applicant->image)) {
				// Delete the single file
				File::delete('uploads/'.$applicant->image);

			}

			// Permanently delete
			$applicant->forceDelete();

			// Log it first
			Activity::log(__FUNCTION__);

			return Redirect::to(route('admin.applicants.index','path=trashed'))->with('success', 'Applicant Permanently Deleted!');
		}

		return Redirect::to(route('admin.applicants.index','path=trashed'))->with('error', 'Applicant Not Found!');
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
			if ( ! $row = $this->applicants->find($id))
			{
				return Redirect::to(route('admin.applicants.index'));
			}
		}
		else
		{
			$row = $this->applicants;
		}

		return $this->view('Career::applicant_form')->data(compact('mode', 'row'))->title('Applicant '.$mode);
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
			'email'      => 'required|unique:applicants',
			'status'	 => 'boolean'
		];

		if ($id)
		{

			if (isset($input['_private'])) {

				list($csrf, $email, $role_id) = explode('::', base64_decode($input['_private']));

				if ($csrf == $input['_token']) {

					$input['email'] 	=  $email;

				}

			}

			$applicant = Applicant::find($id);

			$rules['email'] .= ",email,{$applicant->email},email";

			$messages = $this->validateApplicant($input, $rules);

			if ($messages->isEmpty())
			{


				// Get applicant model to update other profile data
				$applicant->update($input);

				return Redirect::back()->withInput()->with('success', 'Applicant Updated!');

			}
		}
		else
		{

			$messages = $this->validateApplicant($input, $rules);

			if ($messages->isEmpty())
			{
				// Create applicant into the database
				$applicant = Applicant::create($input);

				// Syncing relationship Many To Many // Create New
				//$applicant->roles()->sync(['role_id'=>$input['role_id']]);

				//$code = Activation::create($applicant);

				//Activation::complete($applicant, $code);
			}
		}

		// Log it first
		Activity::log(__FUNCTION__);

		if ($messages->isEmpty())
		{
			return Redirect::to(route('admin.applicants.show',$applicant->id))->with('success', 'Applicant Updated!');
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
				$this->applicants->find($row)->update(['status' => Input::get('select_action')]);
		    }

		    // Set message
		    return Redirect::to(route('admin.applicants.index'))->with('success', 'Applicant Status Changed!');

		} else {

		    // Set message
		    return Redirect::to(route('admin.applicants.index'))->with('error','Data not Available!');
		}
	}

	/**
	 * Validates a applicant.
	 *
	 * @param  array  $data
	 * @param  mixed  $id
	 * @return \Illuminate\Support\MessageBag
	 */
	protected function validateApplicant($data, $rules)
	{
		$validator = Validator::make($data, $rules);

		$validator->passes();

		return $validator->errors();
	}

	public function export() {

		// Log it first
		Activity::log(__FUNCTION__);
			
		// Get type file to export
		$type = Input::get('rel');
		// Get data to export
		$applicants = $this->applicants->select('id', 'applicantname', 'email', 'created_at')->get();
		// Export file to type
		Excel::create('applicants', function($excel) use($applicants) {
		    $excel->sheet('Sheet 1', function($sheet) use($applicants) {
		        $sheet->fromArray($applicants);
		    });
		})->export($type);

	}

}
