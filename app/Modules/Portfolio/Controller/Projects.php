<?php namespace App\Modules\Portfolio\Controller;

// Load Laravel classes
use Route, Request, Session, Redirect, Input, Validator, View, Excel;
// Load main base controller
use App\Modules\BaseAdmin;
// Load main models
use App\Modules\Portfolio\Model\Portfolio,
	App\Modules\Portfolio\Model\Project,
	App\Modules\Portfolio\Model\Client;
// Load Datatable
use Datatables;

class Projects extends BaseAdmin {

	/**
	 * Set projects data.
	 *
	 */
	public $projects;

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

		// Load projects and get repository data from Sentinel
		$this->projects = new Project;
		$this->portfolios = new Portfolio;
		$this->clients = new Client;

	}

	/**
	 * Display a listing of projects.
	 *
	 * @return \Illuminate\View\View
	 */
	public function index()
	{

	   	// Get deleted count
		$deleted = $this->projects->with('client')->onlyTrashed()->get()->count();

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
			// --- datatable handler [".route('admin.projects.index')."]--- //
				var datatable  = $('#datatable-table');
				var controller = datatable.attr('rel');

				$('#datatable-table').DataTable({
					processing: true,
					serverSide: true,
				  	bAutoWidth: false,
					ajax: '".route('admin.projects.datatable')."' + ($.getURLParameter('path') ? '?path=' + $.getURLParameter('path') : ''),
					columns: [
						{data: 'id', name:'id', orderable: false, searchable: false},
						{data: 'name', name: 'name'},
						{data: 'client', name: 'client'},
						{data: 'description', name: 'description'},
						{data: 'status', name: 'status'},
						{data: 'created_at', name: 'created_at'},
						{data: 'updated_at', name: 'updated_at'},
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

	   	return $this->view('Portfolio::project_datatable_index')
		->data($data)
		->scripts($scripts)
		->inlines($inlines)
		->title('Projects List');
	}

	/**
	 * Process datatables ajax request.
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function datatable(Request $request)
	{
		$rows = Input::get('path') === 'trashed' ? $this->projects->with('client')->onlyTrashed()->get() : $this->projects->with('client')->orderBy('index', 'asc')->get();

		return Datatables::of($rows)
			// Set action buttons
			->editColumn('action', function ($row) {
				if (Input::get('path') !== 'trashed') {
					return '
						<a data-rel="tooltip" data-original-title="View" title="" href="'.route('admin.projects.show', $row->id).'" class="btn btn-xs btn-success tooltip-default">
							<i class="ace-icon fa fa-check bigger-120"></i>
						</a>
						<a data-rel="tooltip" data-original-title="Edit"  href="'.route('admin.projects.edit', $row->id).'" class="btn btn-xs btn-info tooltip-default">
							<i class="ace-icon fa fa-pencil bigger-120"></i>
						</a>
						<a data-rel="tooltip" data-original-title="Trashed"  href="'.route('admin.projects.trash', $row->id).'" class="btn btn-xs btn-danger tooltip-default">
							<i class="ace-icon fa fa-trash-o bigger-120"></i>
						</a>';
				} else {
					return '
						<a data-rel="tooltip" data-original-title="Restore!" href="'.route('admin.projects.restored', $row->id).'" class="btn btn-xs btn-primary tooltip-default">
							<i class="ace-icon fa fa-save bigger-120"></i>
						</a>
						<a data-rel="tooltip" data-original-title="Permanent Delete!" href="'.route('admin.projects.delete', $row->id).'" class="btn btn-xs btn-danger">
							<i class="ace-icon fa fa-trash bigger-120"></i>
						</a>';
				}
			})
			// Edit column client
			->editColumn('client', function ($row) {
				return 	'
				<a data-rel="tooltip" data-original-title="Client" href="'.route('admin.clients.show', $row->client->id).'" class="tooltip-default">
					'.$row->client->name.'
				</a>';
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
        $project = $this->projects->findOrFail($id);

		// Set data to return
	   	$data = ['row'=>$project];

	   	// Return data and view
	   	return $this->view('Portfolio::project_show')->data($data)->title('View Project');

	}

	/**
	 * Show the form for creating new project.
	 *
	 * @return \Illuminate\View\View
	 */
	public function create()
	{
		return $this->showForm('create');
	}

	/**
	 * Handle posting of the form for creating new project.
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function store()
	{
		return $this->processForm('create');
	}

	/**
	 * Show the form for updating project.
	 *
	 * @param  int  $id
	 * @return mixed
	 */
	public function edit($id)
	{
		return $this->showForm('update', $id);
	}

	/**
	 * Handle posting of the form for updating project.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function update($id)
	{
		return $this->processForm('update', $id);
	}

	/**
	 * Remove the specified project.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function trash($id)
	{
		if ($project = $this->projects->find($id))
		{

			// Add deleted_at and not completely delete
			$project->delete();

			// Redirect with messages
			return Redirect::to(route('admin.projects.index'))->with('success', 'Project Trashed!');
		}

		return Redirect::to(route('admin.projects.index'))->with('error', 'Project Not Found!');
	}

	/**
	 * Restored the specified project.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function restored($id)
	{
		if ($project = $this->projects->onlyTrashed()->find($id))
		{

			// Restored back from deleted_at database
			$project->restore();

			// Redirect with messages
			return Redirect::to(route('admin.projects.index'))->with('success', 'Project Restored!');
		}

		return Redirect::to(route('admin.projects.index'))->with('error', 'Project Not Found!');
	}
	/**
	 * Remove the specified project.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function delete($id)
	{

		// Get project from id fetch
		if ($project = $this->projects->onlyTrashed()->find($id))
		{

			// Delete from pivot table many to many
			$this->projects->onlyTrashed()->find($id)->client()->detach();

			// Delete if there is an image attached
			if(File::exists('uploads/'.$project->image)) {
				// Delete the single file
				File::delete('uploads/'.$project->image);

			}

			// Permanently delete
			$project->forceDelete();

			return Redirect::to(route('admin.projects.index','path=trashed'))->with('success', 'Project Permanently Deleted!');
		}

		return Redirect::to(route('admin.projects.index','path=trashed'))->with('error', 'Project Not Found!');
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
			if ( ! $row = $this->projects->find($id))
			{
				return Redirect::to(route('admin.projects.index'));
			}
		}
		else
		{
			$row = $this->projects;
		}

		$clients = $this->clients->lists('name', 'id')->all();

		return $this->view('Portfolio::project_form')->data(compact('mode', 'row', 'clients'))->title('Project '.$mode);
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
			'client_id' => 'required',
			'name'  => 'required',
			'description' => 'required',
			'status' => 'boolean'
		];

		if ($id)
		{

			$project = $this->projects->find($id);
			$messages = $this->validateProject($input, $rules);

			if ($messages->isEmpty())
			{

				// Update project model data
				$project->update($input);

			}
		}
		else
		{

			$messages = $this->validateProject($input, $rules);

			if ($messages->isEmpty())
			{
				// Create project into the database
				$project = $this->projects->create($input);

			}
		}

		if ($messages->isEmpty())
		{
			return Redirect::to(route('admin.projects.show', $project->id))->with('success', 'Project Updated!');;
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
				$this->projects->find($row)->update(['status' => Input::get('select_action')]);
		    }

		    // Set message
		    return Redirect::to(route('admin.projects.index'))->with('success', 'Project Status Changed!');

		} else {

		    // Set message
		    return Redirect::to(route('admin.projects.index'))->with('error','Data not Available!');
		}
	}

	/**
	 * Process a file to download.
	 *
	 * @return $file export
	 */
	public function export() {

		// Get type file to export
		$type = Input::get('rel');
		// Get data to export
		$projects = $this->projects->select('id','name','description','status','updated_at','created_at')->get();
		// Export file to type
		Excel::create('projects', function($excel) use($projects) {
			// Set the spreadsheet title, creator, and description
	        $excel->setTitle('Export List');
	        $excel->setCreator('Laravel')->setCompany('laravel.com');
	        $excel->setDescription('export file');

		    $excel->sheet('Sheet 1', function($sheet) use($projects) {
				$sheet->fromArray($projects);
		    });
		})->export($type);

	}

	/**
	 * Validates a project.
	 *
	 * @param  array  $data
	 * @param  mixed  $id
	 * @return \Illuminate\Support\MessageBag
	 */
	protected function validateProject($data, $rules)
	{
		$validator = Validator::make($data, $rules);

		$validator->passes();

		return $validator->errors();
	}

}
