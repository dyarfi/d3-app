<?php namespace App\Modules\Participant\Controller;

// Load Laravel classes
use Route, Request, Session, Redirect, Input, Validator, View, Excel, File;
// Load main base controller
use App\Modules\BaseAdmin;
// Load main models
use App\Modules\Participant\Model\Participant;
// Load Datatable
use Datatables;
// User Activity Logs
use Activity;

class Participants extends BaseAdmin {

	/**
	 * Set participants data.
	 *
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
	   	$data = ['deleted'=>$deleted,'junked'=>Input::get('path')];

		// Load needed scripts
	   	$scripts = [
	   				'dataTables' => asset('themes/ace-admin/js/jquery.dataTables.min.js'),
	   				'dataTableBootstrap'=> asset('themes/ace-admin/js/jquery.dataTables.bootstrap.min.js'),
					'library' => asset("themes/ace-admin/js/library.js")
	   				];

		// Set inline script or style
		$inlines = [
			// Script execution on a specific controller page
			'script' => "
			// --- datatable handler [".route('admin.participants.index')."]--- //
				var datatable  = $('#datatable-table');
				var controller = datatable.attr('rel');

				$('#datatable-table').DataTable({
					processing: true,
					serverSide: true,
					bAutoWidth: false,
					ajax: '".route('admin.participants.datatable')."' + ($.getURLParameter('path') ? '?path=' + $.getURLParameter('path') : ''),
					columns: [
						{data: 'id', name:'id', orderable: false, searchable: false},
						{data: 'name', name: 'name'},
						{data: 'provider', name: 'provider'},
						{data: 'email', name: 'email'},
						{data: 'status', name: 'status'},
						{data: 'join_date', name: 'join_date'},
						{data: 'action', name: 'action', orderable: false, searchable: false}
					],
					language: {
						processing: ''
					},
					fnDrawCallback : function (oSettings) {
						$('#datatable-table > thead > tr > th:first-child')
						.removeClass('sorting_asc')
						.find('input[type=checkbox]')
						.prop('checked',false);
						$('#datatable-table > tbody > tr > td:first-child').addClass('center');
						$('[data-rel=tooltip]').tooltip();
					}
				});
			",
		];

	   	return $this->view('Participant::participant_datatable_index')
		->data($data)
		->scripts($scripts)
		->inlines($inlines)
		->title('Participants List');
	}

	/**
	 * Process datatables ajax request.
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function datatable(Request $request)
	{
		$rows = Input::get('path') === 'trashed' ? $this->participants->onlyTrashed()->get() : $this->participants->orderBy('join_date', 'asc')->get();

		return Datatables::of($rows)
			// Set action buttons
			->editColumn('action', function ($row) {
				if (Input::get('path') !== 'trashed') {
					return '
						<a data-rel="tooltip" data-original-title="View" title="" href="'.route('admin.participants.show', $row->id).'" class="btn btn-xs btn-success tooltip-default">
							<i class="ace-icon fa fa-check bigger-120"></i>
						</a>
						<a data-rel="tooltip" data-original-title="Edit"  href="'.route('admin.participants.edit', $row->id).'" class="btn btn-xs btn-info tooltip-default">
							<i class="ace-icon fa fa-pencil bigger-120"></i>
						</a>
						<a data-rel="tooltip" data-original-title="Trashed"  href="'.route('admin.participants.trash', $row->id).'" class="btn btn-xs btn-danger tooltip-default">
							<i class="ace-icon fa fa-trash-o bigger-120"></i>
						</a>';
				} else {
					return '
						<a data-rel="tooltip" data-original-title="Restore!" href="'.route('admin.participants.restored', $row->id).'" class="btn btn-xs btn-primary tooltip-default">
							<i class="ace-icon fa fa-save bigger-120"></i>
						</a>
						<a data-rel="tooltip" data-original-title="Permanent Delete!" href="'.route('admin.participants.delete', $row->id).'" class="btn btn-xs btn-danger">
							<i class="ace-icon fa fa-trash bigger-120"></i>
						</a>';
				}
			})
			// Edit column name
			->editColumn('name', function ($row) {
				return $row->name;
			})
			// Edit column id
			->editColumn('id', function ($row) {
				return 	'
				<label class="pos-rel">
					<input type="checkbox" class="ace" name="check[]" id="check_'.$row->id.'" value="'.$row->id.'" />
					<span class="lbl"></span>
				</label>';
			})
			// Set description limit
			->editColumn('description', function ($row) {
				return 	str_limit(strip_tags($row->description), 60);
			})
			// Set status icon and text
			->editColumn('status', function ($row) {
				return '
				<span class="label label-'.($row->status == 1 ? 'success' : 'warning').' arrowed-in arrowed-in-right">
					<span class="fa fa-'.($row->status == 1 ? 'flag' : 'exclamation-circle').' fa-sm"></span>
					'.config('setting.status')[$row->status].'
				</span>';
            })
			->rawColumns(['id','action','status'])
			->make(true);
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

			// Log it first
			Activity::log(__FUNCTION__);

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

			// Log it first
			Activity::log(__FUNCTION__);

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

			// Delete if there is an image attached
			if(File::exists('uploads/'.$participant->avatar)) {
				// Delete the single file
				File::delete('uploads/'.$participant->avatar);

			}

			// Permanently delete
			$participant->forceDelete();

			// Log it first
			Activity::log(__FUNCTION__);

			return Redirect::to(route('admin.participants.index','path=trashed'))->with('success', 'Participant Permanently Deleted!');
		}

		return Redirect::to(route('admin.participants.index','path=trashed'))->with('error', 'Participant Not Found!');
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

		// Log it first
		Activity::log(__FUNCTION__);

		if ($messages->isEmpty())
		{
			return Redirect::to(route('admin.participants.show', $participant->id))->with('success', 'Participant Updated!');;
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
	 * Process a file to download.
	 *
	 * @return $file export
	 */
	public function export() {

		// Log it first
		Activity::log(__FUNCTION__);

		// Get type file to export
		$type = Input::get('rel');
		// Get data to export
		$participants = $this->participants->select('id','name','description','status','updated_at','created_at')->get();
		// Export file to type
		Excel::create('participants', function($excel) use($participants) {
			// Set the spreadsheet title, creator, and description
	        $excel->setTitle('Export List');
	        $excel->setCreator('Laravel')->setCompany('laravel.com');
	        $excel->setDescription('export file');

		    $excel->sheet('Sheet 1', function($sheet) use($participants) {
				$sheet->fromArray($participants);
		    });
		})->export($type);

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
