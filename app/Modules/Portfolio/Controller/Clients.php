<?php namespace App\Modules\Portfolio\Controller;

// Load Laravel classes
use Route, Request, Session, Redirect, Input, Validator, View;
// Load main base controller
use App\Modules\BaseAdmin;
// Load main models
use App\Modules\Portfolio\Model\Portfolio,
	App\Modules\Portfolio\Model\Project,
	App\Modules\Portfolio\Model\Client;
// Load Datatable
use Datatables;

class Clients extends BaseAdmin {
	/**
	 * Holds the Sentinel Users repository.
	 *
	 * @var \Cartalyst\Sentinel\Users\EloquentUser
	 */
	protected $clients;

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

		// Load clients and get repository data from database
		$this->clients = new Client;

	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index() {

		// Get deleted count
		$deleted = $this->clients->onlyTrashed()->get()->count();

	   	// Set data to return
	   	$data = ['deleted' => $deleted,'junked' => Input::get('path')];

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
			// --- datatable handler [".route('admin.clients.index')."]--- //
				var datatable  = $('#datatable-table');
				var controller = datatable.attr('rel');

				$('#datatable-table').DataTable({
					processing: true,
					serverSide: true,
					ajax: '".route('admin.clients.datatable')."' + ($.getURLParameter('path') ? '?path=' + $.getURLParameter('path') : ''),
					columns: [
						{data: 'id', name:'id', orderable: false, searchable: false},
						{data: 'name', name: 'name'},
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

		// Return data and view
	   	return $this->view('Portfolio::client_datatable_index')
		->data($data)
		->scripts($scripts)
		->inlines($inlines)
		->title('Client List');
	}

	/**
	 * Process datatables ajax request.
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function datatable(Request $request)
	{
		$rows = Input::get('path') === 'trashed' ? $this->clients->onlyTrashed()->get() : $this->clients->orderBy('index', 'asc')->get();

		return Datatables::of($rows)
			// Set action buttons
			->editColumn('action', function ($row) {
				if (Input::get('path') !== 'trashed') {
					return '
						<a data-rel="tooltip" data-original-title="View" title="" href="'.route('admin.clients.show', $row->id).'" class="btn btn-xs btn-success tooltip-default">
							<i class="ace-icon fa fa-check bigger-120"></i>
						</a>
						<a data-rel="tooltip" data-original-title="Edit"  href="'.route('admin.clients.edit', $row->id).'" class="btn btn-xs btn-info tooltip-default">
							<i class="ace-icon fa fa-pencil bigger-120"></i>
						</a>
						<a data-rel="tooltip" data-original-title="Trashed"  href="'.route('admin.clients.trash', $row->id).'" class="btn btn-xs btn-danger tooltip-default">
							<i class="ace-icon fa fa-trash-o bigger-120"></i>
						</a>';
				} else {
					return '
						<a data-rel="tooltip" data-original-title="Restore!" href="'.route('admin.clients.restored', $row->id).'" class="btn btn-xs btn-primary tooltip-default">
							<i class="ace-icon fa fa-save bigger-120"></i>
						</a>
						<a data-rel="tooltip" data-original-title="Permanent Delete!" href="'.route('admin.clients.delete', $row->id).'" class="btn btn-xs btn-danger">
							<i class="ace-icon fa fa-trash bigger-120"></i>
						</a>';
				}
			})
			// Edit column name
			->editColumn('name', function ($row) {
				return ($row->index) ? $row->index . '.' . $row->name : $row->name;
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
        $client = $this->clients->find($id);

		// Set data to return
	   	$data = ['row'=>$client];

	   	// Return data and view
	   	return $this->view('Portfolio::client_show')->data($data)->title('View Client');

	}

	/**
	 * Show the form for creating new client.
	 *
	 * @return \Illuminate\View\View
	 */
	public function create()
	{
		return $this->showForm('create');
	}

	/**
	 * Handle posting of the form for creating new client.
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function store()
	{
		return $this->processForm('create');
	}

	/**
	 * Show the form for updating client.
	 *
	 * @param  int  $id
	 * @return mixed
	 */
	public function edit($id)
	{
		return $this->showForm('update', $id);
	}

	/**
	 * Handle posting of the form for updating client.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function update($id)
	{
		return $this->processForm('update', $id);
	}

	/**
	 * Remove the specified client.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function trash($id)
	{
		if ($client = $this->clients->find($id))
		{
			// Add deleted_at and not completely delete
			$client->delete();

			// Redirect with messages
			return Redirect::to(route('admin.clients.index'))->with('success', 'Client Trashed!');
		}

		return Redirect::to(route('admin.clients.index'))->with('error', 'Client Not Found!');
	}

	/**
	 * Restored the specified client.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function restored($id)
	{
		if ($client = $this->clients->onlyTrashed()->find($id))
		{

			// Restored back from deleted_at database
			$client->restore();

			// Redirect with messages
			return Redirect::to(route('admin.clients.index'))->with('success', 'Client Restored!');
		}

		return Redirect::to(route('admin.clients.index'))->with('error', 'Client Not Found!');;
	}

	/**
	 * Delete the specified client.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function delete($id)
	{
		if ($client = $this->clients->onlyTrashed()->find($id))
		{

			// Completely delete from database
			$client->forceDelete();

			// Redirect with messages
			return Redirect::to(route('admin.clients.index'))->with('success', 'Client Permanently Deleted!');
		}

		return Redirect::to(route('admin.clients.index'))->with('error', 'Client Not Found!');
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
			if ( ! $row = $this->clients->find($id))
			{
				return Redirect::to(route('admin.clients.index'))->withErrors('Not found data!');;
			}
		}
		else
		{
			$row = $this->clients;
		}

		// Set model to form
		$model = $this->clients;

		return $this->view('Portfolio::client_form')->data(compact('mode','row','model'))->title('Client '.$mode);
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

		// Set client slug
		$input['slug'] = isset($input['name']) ? str_slug($input['name'],'_') : '';

		$rules = [
			'name' 	   	   => 'required',
			//'slug' 		   => 'required',
			'description'  => 'required',
			'status'	   => 'boolean',
			'image' 	   => ($mode == 'create' ? 'required|' : '').'mimes:jpg,jpeg,png|max:999',
			'index'	   	   => 'numeric|digits_between:1,999',
		];

		if ($id)
		{
			// Set default client
			$client = $this->clients->find($id);

			// Set validation messages
			$messages = $this->validateClient($input, $rules);

			// If user upload a file
			if (isset($input['image']) && Input::hasFile('image')) {

				// Set filename
				$filename = $this->imageUploadToDb($input['image'], 'uploads', 'client_');

			}

			if ($messages->isEmpty())
			{
				// Get all request
				$result = $input;

				// Slip user id
				$result = array_set($result, 'user_id', $this->user->id);

				// Slip image file
				$result = isset($filename) ? array_set($input, 'image', $filename) : $result;

				// Set input to database
				$client->update($result);
			}

		}
		else
		{

			// Set validation messages
			$messages = $this->validateClient($input, $rules);

			// If user upload a file
			if (isset($input['image']) && Input::hasFile('image')) {

				// Set filename
				$filename = $this->imageUploadToDb($input['image'], 'uploads', 'client_');

			}

			if ($messages->isEmpty())
			{
				// Get all request
				$result = $input;

				// Slip user id
				$result = array_set($result, 'user_id', $this->user->id);

				// Slip image file
				$result = isset($input['image']) ? array_set($result, 'image', @$filename) : array_set($result, 'image', '');

				// Set input to database
				$client = $this->clients->create($result);

			}
		}

		if ($messages->isEmpty())
		{
			return Redirect::to(route('admin.clients.show',$client->id))->with('success', 'Client Updated!');
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
				$this->clients->find($row)->update(['status' => Input::get('select_action')]);
		    }

		    // Set message
		    return Redirect::to(route('admin.clients.index'))->with('success', 'Client Status Changed!');

		} else {

		    // Set message
		    return Redirect::to(route('admin.clients.index'))->with('error','Data not Available!');
		}
	}

	/**
	 * Process a file upload save the filename to DB.
	 *
	 * @param  array  $file
	 * @param  string $path
	 * @param  string $type
	 * @return $filename
	 */
	protected function imageUploadToDb($file='', $path='', $type='')
	{
		// Set filename upload
		$filename = '';

		// Check if input and upload already assigned
		if (!empty($file) && !$file->getError()) {
			$destinationpath = public_path($path); // Upload path start with slashes
			$extension = $file->getClientOriginalExtension(); // Getting image extension
			$filename = $type . rand(11111,99999) . '.' . $extension; // Renaming image
			$file->move($destinationpath, $filename); // Uploading file and move to given path
		}

		return $filename;
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
		$clients = $this->clients->select('id','name','description','status','updated_at','created_at')->get();
		// Export file to type
		Excel::create('clients', function($excel) use($clients) {
			// Set the spreadsheet title, creator, and description
			$excel->setTitle('Export List');
			$excel->setCreator('Laravel')->setCompany('laravel.com');
			$excel->setDescription('export file');

			$excel->sheet('Sheet 1', function($sheet) use($clients) {
				$sheet->fromArray($clients);
			});
		})->export($type);

	}

	/**
	 * Validates a client.
	 *
	 * @param  array  $data
	 * @param  mixed  $id
	 * @return \Illuminate\Support\MessageBag
	 */
	protected function validateClient($data, $rules)
	{
		$validator = Validator::make($data, $rules);

		$validator->passes();

		return $validator->errors();
	}

}
