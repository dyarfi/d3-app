<?php namespace App\Modules\Banner\Controller;

// Load Laravel classes
use Route, Request, Session, Redirect, Input, Image, Validator, View, Excel, File;
//use Illuminate\Support\Facades\Storage;
//use Illuminate\Support\Facades\File;
// Load main base controller
use App\Modules\BaseAdmin;
// Load main models
use App\Modules\Banner\Model\Banner;
// Load Datatable
use Datatables;

class Banners extends BaseAdmin {

	/**
	 * Set banners data.
	 *
	 */
	protected $banners;

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

		// Load banners and get repository data from database
		$this->banners = new Banner;

	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index() {

	   	// Get deleted count
		$deleted = $this->banners->onlyTrashed()->get()->count();

	   	// Set data to return
	   	$data = ['deleted' => $deleted,'junked' => Input::get('path')];

		// Load needed scripts
	   	$scripts = [
	   				'dataTables' => asset('themes/ace-admin/js/jquery.dataTables.min.js'),
	   				'dataTableBootstrap'=> asset('themes/ace-admin/js/jquery.dataTables.bootstrap.min.js'),
					// ColorBox
			   		'jquery.colorbox' => asset('themes/ace-admin/js/jquery.colorbox.min.js'),
					'library' => asset("themes/ace-admin/js/library.js")
	   				];

		$styles 	= [
	 	   			'jquery.colorbox' => asset('themes/ace-admin/css/colorbox.min.css'),
	 	   			];

		// Set inline script or style
		$inlines = [
			// Script execution on a specific controller page
			'script' => "
			// --- datatable handler [".route('admin.banners.index')."]--- //
				var datatable  = $('#datatable-table');
				var controller = datatable.attr('rel');

				$('#datatable-table').DataTable({
					processing: true,
					serverSide: true,
					bAutoWidth: false,
					ajax: '".route('admin.banners.datatable')."' + ($.getURLParameter('path') ? '?path=' + $.getURLParameter('path') : ''),
					columns: [
						{data: 'id', name:'id', orderable: false, searchable: false},
						{data: 'name', name: 'name'},
						{data: 'image', name: 'image'},
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
						//FormInit.handleColorbox();
					}
				});
			",
		];

		// Return data and view
	   	return $this->view('Banner::banner_datatable_index')
		->data($data)
		->scripts($scripts)
		->styles($styles)
		->inlines($inlines)
		->title('Banner List');
	}

	/**
	 * Process datatables ajax request.
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function datatable(Request $request)
	{
		$rows = Input::get('path') === 'trashed' ? $this->banners->onlyTrashed()->get() : $this->banners->orderBy('index', 'asc')->get();

		return Datatables::of($rows)
			// Set action buttons
			->editColumn('action', function ($row) {
				if (Input::get('path') !== 'trashed') {
					return '
						<a data-rel="tooltip" data-original-title="View" title="" href="'.route('admin.banners.show', $row->id).'" class="btn btn-xs btn-success tooltip-default">
							<i class="ace-icon fa fa-check bigger-120"></i>
						</a>
						<a data-rel="tooltip" data-original-title="Edit"  href="'.route('admin.banners.edit', $row->id).'" class="btn btn-xs btn-info tooltip-default">
							<i class="ace-icon fa fa-pencil bigger-120"></i>
						</a>
						<a data-rel="tooltip" data-original-title="Trashed"  href="'.route('admin.banners.trash', $row->id).'" class="btn btn-xs btn-danger tooltip-default">
							<i class="ace-icon fa fa-trash-o bigger-120"></i>
						</a>';
				} else {
					return '
						<a data-rel="tooltip" data-original-title="Restore!" href="'.route('admin.banners.restored', $row->id).'" class="btn btn-xs btn-primary tooltip-default">
							<i class="ace-icon fa fa-save bigger-120"></i>
						</a>
						<a data-rel="tooltip" data-original-title="Permanent Delete!" href="'.route('admin.banners.delete', $row->id).'" class="btn btn-xs btn-danger">
							<i class="ace-icon fa fa-trash bigger-120"></i>
						</a>';
				}
			})
			// Edit column name
			->editColumn('name', function ($row) {
				$html = ($row->index) ? $row->index . '. ' . $row->name : $row->name;
				return $html;
			})
			// Edit column image
			->editColumn('image', function ($row) {
				$html = '<a data-rel="colorbox" class="cboxElement" href="'.asset('uploads/'.$row->image).'"><img src="'.asset('uploads/'.$row->image).'" height="50px"/></a>';
				return $html;
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
        $banner = $this->banners->find($id);

		// Set data to return
	   	$data = ['row'=>$banner];

	   	// Return data and view
	   	return $this->view('Banner::banner_show')->data($data)->title('View Banner');

	}

	/**
	 * Show the form for creating new banner.
	 *
	 * @return \Illuminate\View\View
	 */
	public function create()
	{
		return $this->showForm('create');
	}

	/**
	 * Handle posting of the form for creating new banner.
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function store()
	{
		return $this->processForm('create');
	}

	/**
	 * Show the form for updating banner.
	 *
	 * @param  int  $id
	 * @return mixed
	 */
	public function edit($id)
	{
		return $this->showForm('update', $id);
	}

	/**
	 * Handle posting of the form for updating banner.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function update($id)
	{
		return $this->processForm('update', $id);
	}

	/**
	 * Remove the specified banner.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function trash($id)
	{
		if ($banner = $this->banners->find($id))
		{
			// Add deleted_at and not completely delete
			$banner->delete();

			// Redirect with messages
			return Redirect::to(route('admin.banners.index'))->with('success', 'Banner Trashed!');
		}

		return Redirect::to(route('admin.banners.index'))->with('error', 'Banner Not Found!');
	}

	/**
	 * Restored the specified banner.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function restored($id)
	{
		if ($banner = $this->banners->onlyTrashed()->find($id))
		{

			// Restored back from deleted_at database
			$banner->restore();

			// Redirect with messages
			return Redirect::to(route('admin.banners.index'))->with('success', 'Banner Restored!');
		}

		return Redirect::to(route('admin.banners.index'))->with('error', 'Banner Not Found!');;
	}

	/**
	 * Delete the specified banner.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function delete($id)
	{
		if ($banner = $this->banners->onlyTrashed()->find($id))
		{
			// Delete if there is an image attached
			if(File::exists('uploads/'.$banner->image)) {
				// Delete the single file
				File::delete('uploads/'.$banner->image);

			}

			// Completely delete from database
			$banner->forceDelete();

			// Redirect with messages
			return Redirect::to(route('admin.banners.index','path=trashed'))->with('success', 'Banner Permanently Deleted!');
		}

		return Redirect::to(route('admin.banners.index','path=trashed'))->with('error', 'Banner Not Found!');
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
			if ( ! $row = $this->banners->find($id))
			{
				return Redirect::to(route('admin.banners.index'))->withErrors('Not found data!');;
			}
		}
		else
		{
			$row = $this->banners;
		}

		// Set division model to name and id only for lookup input
		//$divisions = $this->divisions->lists('name', 'id')->all();

	   	// Load needed javascripts
	   	$scripts = [
					'bootstrap-datepicker'=> asset('themes/ace-admin/js/bootstrap-datepicker.min.js'),
					'library' => asset('themes/ace-admin/js/library.js')
				];

		// Load needed stylesheets
	   	$styles = ['stylesheet'=> 'themes/ace-admin/css/datepicker.min.css'];

		return $this->view('Banner::banner_form')->data(compact('mode', 'row'/*,'divisions'*/))->scripts($scripts)->styles($styles)->title('Banner '.$mode);
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
			'image'  	   => ($mode == 'create') ? 'required' : '',
			'status'	   => 'boolean'
		];

		if ($id)
		{
			$banner = $this->banners->find($id);

			$messages = $this->validateBanner($input, $rules);

			// If user upload a file
			if (isset($input['image']) && Input::hasFile('image')) {

				// Set filename
				$filename = $this->imageUploadToDb($input['image'], 'uploads', 'banner_');

			}
			else {

				$filename = $banner->image;

			}

			if ($messages->isEmpty())
			{
				// Get all request
				$result = $input;

				// Slip user id
				$result = array_set($result, 'user_id', $this->user->id);

				// Slip image file
				$result = isset($filename) ? array_set($input, 'image', $filename) : $result;

				$banner->update($result);
			}

		}
		else
		{
			$messages = $this->validateBanner($input, $rules);

			// If user upload a file
			if (isset($input['image']) && Input::hasFile('image')) {

				// Set filename
				$filename = $this->imageUploadToDb($input['image'], 'uploads', 'banner_');

			}

			if ($messages->isEmpty())
			{
				// Get all request
				$result = $input;

				// Slip user id
				$result = array_set($result, 'user_id', $this->user->id);

				// Slip image file
				$result = isset($input['image']) ? array_set($result, 'image', @$filename) : array_set($result, 'image', '');

				//$banner = $this->banners->create($input);
				$banner = $this->banners->create($result);

			}
		}

		if ($messages->isEmpty())
		{
			return Redirect::to(route('admin.banners.show', $banner->id))->with('success', 'Banner Updated!');
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
				$this->banners->find($row)->update(['status' => Input::get('select_action')]);
		    }

		    // Set message
		    return Redirect::to(route('admin.banners.index'))->with('success', 'Banner Status Changed!');

		} else {

		    // Set message
		    return Redirect::to(route('admin.banners.index'))->with('error','Data not Available!');
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
		$banners = $this->banners->select('id','name','image','description','status','updated_at','created_at')->get();
		// Export file to type
		Excel::create('banners', function($excel) use($banners) {
			// Set the spreadsheet title, creator, and description
			$excel->setTitle('Export List');
			$excel->setCreator('Laravel')->setCompany('laravel.com');
			$excel->setDescription('export file');

			$excel->sheet('Sheet 1', function($sheet) use($banners) {
				$sheet->fromArray($banners);
			});
		})->export($type);

	}

	/**
	 * Validates a banner.
	 *
	 * @param  array  $data
	 * @param  mixed  $id
	 * @return \Illuminate\Support\MessageBag
	 */
	protected function validateBanner($data, $rules)
	{
		$validator = Validator::make($data, $rules);

		$validator->passes();

		return $validator->errors();
	}


}
