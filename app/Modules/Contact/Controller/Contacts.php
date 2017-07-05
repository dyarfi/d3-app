<?php namespace App\Modules\Contact\Controller;

// Load Laravel classes
use Route, Request, Session, Redirect, Input, Validator, View, Excel, File;
// Load main base controller
use App\Modules\BaseAdmin;
// Load main models
use App\Modules\Contact\Model\Contact,
	App\Modules\User\Model\User;
// Load Datatable
use Datatables;

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

	   	// Get deleted count
		$deleted = $this->contacts->onlyTrashed()->get()->count();

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
 		   // --- datatable handler [".route('admin.contacts.index')."]--- //
 			   var datatable  = $('#datatable-table');
 			   var controller = datatable.attr('rel');

 			   $('#datatable-table').DataTable({
 				   processing: true,
 				   serverSide: true,
				   bAutoWidth: false,
 				   ajax: '".route('admin.contacts.datatable')."' + ($.getURLParameter('path') ? '?path=' + $.getURLParameter('path') : ''),
 				   columns: [
 					   {data: 'id', name:'id', orderable: false, searchable: false},
 					   {data: 'name', name: 'name'},
 					   {data: 'email', name: 'email'},
 					   {data: 'phone', name: 'phone'},
					   {data: 'subject', name: 'subject'},
					   {data: 'status', name: 'status'},
 					   {data: 'created_at', name: 'created_at'},
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
	   	return $this->view('Contact::datatable_index')
		->data($data)
		->scripts($scripts)
		->inlines($inlines)
		->title('Contact List');
	}

	/**
	 * Process datatables ajax request.
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function datatable(Request $request)
	{
		$rows = Input::get('path') === 'trashed' ? $this->contacts->onlyTrashed()->get() : $this->contacts->orderBy('created_at', 'asc')->get();

		return Datatables::of($rows)
			// Set action buttons
			->editColumn('action', function ($row) {
				if (Input::get('path') !== 'trashed') {
					return '
						<a data-rel="tooltip" data-original-title="View" title="" href="'.route('admin.contacts.show', $row->id).'" class="btn btn-xs btn-success tooltip-default">
							<i class="ace-icon fa fa-check bigger-120"></i>
						</a>
						<a data-rel="tooltip" data-original-title="Edit"  href="'.route('admin.contacts.edit', $row->id).'" class="btn btn-xs btn-info tooltip-default">
							<i class="ace-icon fa fa-pencil bigger-120"></i>
						</a>
						<a data-rel="tooltip" data-original-title="Trashed"  href="'.route('admin.contacts.trash', $row->id).'" class="btn btn-xs btn-danger tooltip-default">
							<i class="ace-icon fa fa-trash-o bigger-120"></i>
						</a>';
				} else {
					return '
						<a data-rel="tooltip" data-original-title="Restore!" href="'.route('admin.contacts.restored', $row->id).'" class="btn btn-xs btn-primary tooltip-default">
							<i class="ace-icon fa fa-save bigger-120"></i>
						</a>
						<a data-rel="tooltip" data-original-title="Permanent Delete!" href="'.route('admin.contacts.delete', $row->id).'" class="btn btn-xs btn-danger">
							<i class="ace-icon fa fa-trash bigger-120"></i>
						</a>';
				}
			})
			// Edit column client
			/*
			->editColumn('client', function ($row) {
				return 	'
				<a data-rel="tooltip" data-original-title="Client" href="'.route('admin.clients.show', $row->client->id).'" class="tooltip-default">
					'.$row->client->name.'
				</a>';
			})
			*/
			// Edit column id
			->editColumn('id', function ($row) {
				return 	'
				<label class="pos-rel">
					<input type="checkbox" class="ace" name="check[]" id="check_'.$row->id.'" value="'.$row->id.'" />
					<span class="lbl"></span>
				</label>';
			})
			// Set subject limit
			->editColumn('subject', function ($row) {
				return 	str_limit(strip_tags($row->subject), 28);
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

			// Delete if there is an image attached
			if(File::exists('uploads/'.$contact->image)) {
				// Delete the single file
				File::delete('uploads/'.$contact->image);

			}

			// Completely delete from database
			$contact->forceDelete();

			// Redirect with messages
			return Redirect::to(route('admin.contacts.index','path=trashed'))->with('success', 'Contact Permanently Deleted!');
		}

		return Redirect::to(route('admin.contacts.index','path=trashed'))->with('error', 'Contact Not Found!');
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
	 * Process a file to download.
	 *
	 * @return $file export
	 */
	public function export() {

		// Get type file to export
		$type = Input::get('rel');
		// Get data to export
		$contacts = $this->contacts->select('id','name','description','status','updated_at','created_at')->get();
		// Export file to type
		Excel::create('contacts', function($excel) use($contacts) {
			// Set the spreadsheet title, creator, and description
			$excel->setTitle('Export List');
			$excel->setCreator('Laravel')->setCompany('laravel.com');
			$excel->setDescription('export file');

			$excel->sheet('Sheet 1', function($sheet) use($contacts) {
				$sheet->fromArray($contacts);
			});
		})->export($type);

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
