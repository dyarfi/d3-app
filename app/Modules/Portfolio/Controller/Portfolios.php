<?php namespace App\Modules\Portfolio\Controller;

// Load Laravel classes
use Route, Request, Session, Redirect, Input, Validator, View, Image, Excel;
// Load main base controller
use App\Modules\BaseAdmin;
// Load main models
use App\Modules\Portfolio\Model\Portfolio,
	App\Modules\Portfolio\Model\Project,
	App\Modules\Portfolio\Model\Client;
// Load Datatable
use Datatables;

class Portfolios extends BaseAdmin {
	/**
	 * Holds the Portfolio Module repository.
	 *
	 * @var App\Modules\Portfolio\Model\Portfolio
	 */
	protected $portfolios;

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

		// Load portfolios and get repository data from database
		$this->portfolios 	= new Portfolio;
		$this->clients 		= new Client;
		$this->projects 	= new Project;

		// Crop to fit image size
		$this->imgFit 		= [1200,1200];

	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index() {

	   	// Get deleted count
		$deleted = $this->portfolios->onlyTrashed()->get()->count();

	   	// Set data to return
	   	$data = ['deleted' => $deleted, 'junked' => Input::get('path')];

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
			// --- datatable handler [".route('admin.portfolios.index')."]--- //
				var datatable  = $('#datatable-table');
				var controller = datatable.attr('rel');

				$('#datatable-table').DataTable({
					processing: true,
					serverSide: true,
					ajax: '".route('admin.portfolios.datatable')."' + ($.getURLParameter('path') ? '?path=' + $.getURLParameter('path') : ''),
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
	   	return $this->view('Portfolio::portfolio_datatable_index')
		->data($data)
		->scripts($scripts)
		->inlines($inlines)
		->title('Portfolio List');

	}

	/**
     * Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function datatable(Request $request)
    {
		$rows = Input::get('path') === 'trashed' ? $this->portfolios->with('project')->onlyTrashed()->get() : $this->portfolios->with('project')->orderBy('index', 'asc')->get();

		return Datatables::of($rows)
			// Set action buttons
            ->editColumn('action', function ($row) {
				if (Input::get('path') !== 'trashed') {
					return '
						<a data-rel="tooltip" data-original-title="View" title="" href="'.route('admin.portfolios.show', $row->id).'" class="btn btn-xs btn-success tooltip-default">
							<i class="ace-icon fa fa-check bigger-120"></i>
						</a>
						<a data-rel="tooltip" data-original-title="Edit"  href="'.route('admin.portfolios.edit', $row->id).'" class="btn btn-xs btn-info tooltip-default">
							<i class="ace-icon fa fa-pencil bigger-120"></i>
						</a>
						<a data-rel="tooltip" data-original-title="Trashed"  href="'.route('admin.portfolios.trash', $row->id).'" class="btn btn-xs btn-danger tooltip-default">
							<i class="ace-icon fa fa-trash-o bigger-120"></i>
						</a>';
				} else {
					return '
						<a data-rel="tooltip" data-original-title="Restore!" href="'.route('admin.portfolios.restored', $row->id).'" class="btn btn-xs btn-primary tooltip-default">
							<i class="ace-icon fa fa-save bigger-120"></i>
						</a>
						<a data-rel="tooltip" data-original-title="Permanent Delete!" href="'.route('admin.portfolios.delete', $row->id).'" class="btn btn-xs btn-danger">
							<i class="ace-icon fa fa-trash bigger-120"></i>
						</a>';
				}
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
        $portfolio = $this->portfolios->find($id);

		// Set data to return
	   	$data = ['row'=>$portfolio];

	   	// Return data and view
	   	return $this->view('Portfolio::portfolio_show')
		->data($data)
		->title('View Portfolio');

	}

	/**
	 * Show the form for creating new portfolio.
	 *
	 * @return \Illuminate\View\View
	 */
	public function create()
	{
		return $this->showForm('create');
	}

	/**
	 * Handle posting of the form for creating new portfolio.
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function store()
	{
		return $this->processForm('create');
	}

	/**
	 * Show the form for updating portfolio.
	 *
	 * @param  int  $id
	 * @return mixed
	 */
	public function edit($id)
	{
		return $this->showForm('update', $id);
	}

	/**
	 * Handle posting of the form for updating portfolio.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function update($id)
	{
		return $this->processForm('update', $id);
	}

	/**
	 * Remove the specified portfolio.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function trash($id)
	{
		if ($portfolio = $this->portfolios->find($id))
		{
			// Add deleted_at and not completely delete
			$portfolio->delete();

			// Redirect with messages
			return Redirect::to(route('admin.portfolios.index'))->with('success', 'Portfolio Trashed!');
		}

		return Redirect::to(route('admin.portfolios.index'))->with('error', 'Portfolio Not Found!');
	}

	/**
	 * Restored the specified portfolio.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function restored($id)
	{
		if ($portfolio = $this->portfolios->onlyTrashed()->find($id))
		{

			// Restored back from deleted_at database
			$portfolio->restore();

			// Redirect with messages
			return Redirect::to(route('admin.portfolios.index'))->with('success', 'Portfolio Restored!');
		}

		return Redirect::to(route('admin.portfolios.index'))->with('error', 'Portfolio Not Found!');;
	}

	/**
	 * Delete the specified portfolio.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function delete($id)
	{
		if ($portfolio = $this->portfolios->onlyTrashed()->find($id))
		{

			// Completely delete from database
			$portfolio->forceDelete();

			// Redirect with messages
			return Redirect::to(route('admin.portfolios.index'))->with('success', 'Portfolio Permanently Deleted!');
		}

		return Redirect::to(route('admin.portfolios.index'))->with('error', 'Portfolio Not Found!');
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
			if ( ! $row = $this->portfolios->find($id))
			{
				return Redirect::to(route('admin.portfolios.index'))->withErrors('Not found data!');;
			}
			$tags 		= $row->tags;
		}
		else
		{
			$row 		= $this->portfolios;
			$tags 		= $this->portfolios->allTags();
		}

		$model	 	= $this->portfolios;

		$clients 	= $this->clients->lists('name', 'id')->all();

		$projects 	= $this->projects->lists('name', 'id')->all();

		$tags		= $tags;

		$scripts = [
			'bootstrap-tag'=>asset("themes/ace-admin/js/bootstrap-tag.min.js"),
			'ckeditor'=>asset('themes/ace-admin/plugins/ckeditor/ckeditor.js'),
			'library'=>asset("themes/ace-admin/js/library.js")
		];

		return $this->view('Portfolio::portfolio_form')
		->data(compact('mode','row','clients','projects','portfolios','tags','model'))
		->scripts($scripts)
		->title('Portfolio '.$mode);
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

		// Set portfolio slug
		$input['slug'] = isset($input['name']) ? str_slug($input['name'],'_') : '';

		$rules = [
			'client_id'   => 'required',
			'project_id'  => 'required',
			'name' 	   	  => 'required',
			//'slug' 		   => 'required',
			'description'  => 'required',
			'status'	   => 'boolean',
			'image' 	   => ($mode == 'create' ? 'required|' : '').'mimes:jpg,jpeg,png|max:999',
			'index'	   	   => 'numeric|digits_between:1,999',
		];
		if ($id)
		{
			// Set default portfolio
			$portfolio 	= $this->portfolios->find($id);

			// Set validation messages
			$messages 	= $this->validatePortfolio($input, $rules);

			// If user upload a file
			if (isset($input['image']) && Input::hasFile('image')) {

				// Set filename
				$filename = $this->imageUploadToDb($input['image'], 'uploads', 'portfolio_');

			}

			// If validation message empty
			if ($messages->isEmpty())
			{
				// Get all request
				$result = $input;

				// Slip user id
				$result = array_set($result, 'user_id', $this->user->id);

				// Slip image file
				$result = isset($filename) ? array_set($input, 'image', $filename) : $result;

				// Set input to database
				$portfolio->update($result);

				// Using the `slug` column
				$portfolio->setTags($result['tags']);

			}

		}
		else
		{

			// Set validation messages
			$messages = $this->validatePortfolio($input, $rules);

			// If user upload a file
			if (isset($input['image']) && Input::hasFile('image')) {

				// Set filename
				$filename = $this->imageUploadToDb($input['image'], 'uploads', 'portfolio_');

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
				$portfolio = $this->portfolios->create($result);

				// Using the `slug` column
				$portfolio->setTags($result['tags']);

			}
		}

		if ($messages->isEmpty())
		{
			return Redirect::to(route('admin.portfolios.show', $portfolio->id))->with('success', 'Portfolio Updated!');
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
				$this->portfolios->find($row)->update(['status' => Input::get('select_action')]);
		    }

		    // Set message
		    return Redirect::to(route('admin.portfolios.index'))->with('success', 'Portfolio Status Changed!');

		} else {

		    // Set message
		    return Redirect::to(route('admin.portfolios.index'))->with('error','Data not Available!');
		}
	}

	/**
	 * List Taggable data at the specified portfolio.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function tags($id='')
	{
		if ($id) {
			if ($portfolio = $this->portfolios->find($id)) {
				// Return Json Response with specific item
				return response()->json($portfolio->tags->lists('name'), 200);
			}
		} else {
			// Return Json Response
			return response()->json($this->portfolios->allTags()->lists('name'), 200);
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
		$portfolios = $this->portfolios->select('id','name','description','status','updated_at','created_at')->get();
		// Export file to type
		Excel::create('portfolios', function($excel) use($portfolios) {
			// Set the spreadsheet title, creator, and description
	        $excel->setTitle('Export List');
	        $excel->setCreator('Laravel')->setCompany('laravel.com');
	        $excel->setDescription('export file');

		    $excel->sheet('Sheet 1', function($sheet) use($portfolios) {
				$sheet->fromArray($portfolios);
		    });
		})->export($type);

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

			// Upload path
			$destinationpath = public_path($path);
			// Getting image extension
			$extension = $file->getClientOriginalExtension();
			// Renaming image
			$filename = $type . rand(11111,99999) . '.' . $extension;
			// Uploading file and move to given path
			$file->move($destinationpath, $filename);
			// Set intervention image for image manipulation
			$image_fit = implode('x',$this->imgFit);
			$image = Image::make($path .'/'. $filename);
			$image->fit($this->imgFit[0],$this->imgFit[1])->save($path .'/'. $image_fit.'px_'. $filename);

		}

		return $filename;
	}

	/**
	 * Validates a portfolio.
	 *
	 * @param  array  $data
	 * @param  mixed  $id
	 * @return \Illuminate\Support\MessageBag
	 */
	protected function validatePortfolio($data, $rules)
	{
		$validator = Validator::make($data, $rules);

		$validator->passes();

		return $validator->errors();
	}


}
