<?php namespace App\Modules\Blog\Controller;

// Load Laravel classes
use Route, Request, Session, Redirect, Input, Validator, View, Excel, File, Storage;
// Load main base controller
use App\Modules\BaseAdmin;
// Load main models
use App\Modules\Blog\Model\Blog,
	App\Modules\Blog\Model\BlogCategory;
// Load Datatable
use Datatables;

class BlogCategories extends BaseAdmin {

	/**
	 * Set categories data.
	 *
	 */
	protected $categories;

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

		// Load categories and get repository data from database
		$this->categories = new BlogCategory;

	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index() {

	   	// Get deleted count
		$deleted = $this->categories->onlyTrashed()->get()->count();

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
 		   // --- datatable handler [".route('admin.blogcategories.index')."]--- //
 			   var datatable  = $('#datatable-table');
 			   var controller = datatable.attr('rel');

 			   $('#datatable-table').DataTable({
 				   processing: true,
 				   serverSide: true,
				   bAutoWidth: false,
 				   ajax: '".route('admin.blogcategories.datatable')."' + ($.getURLParameter('path') ? '?path=' + $.getURLParameter('path') : ''),
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
	   	return $this->view('Blog::category_datatable_index')
		->data($data)
		->scripts($scripts)
		->inlines($inlines)
		->title('Blog Category List');
	}

	/**
	 * Process datatables ajax request.
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function datatable(Request $request)
	{
		$rows = Input::get('path') === 'trashed' ? $this->categories->onlyTrashed()->get() : $this->categories->orderBy('index', 'asc')->get();

		return Datatables::of($rows)
			// Set action buttons
			->editColumn('action', function ($row) {
				if (Input::get('path') !== 'trashed') {
					return '
						<a data-rel="tooltip" data-original-title="View" title="" href="'.route('admin.blogcategories.show', $row->id).'" class="btn btn-xs btn-success tooltip-default">
							<i class="ace-icon fa fa-check bigger-120"></i>
						</a>
						<a data-rel="tooltip" data-original-title="Edit"  href="'.route('admin.blogcategories.edit', $row->id).'" class="btn btn-xs btn-info tooltip-default">
							<i class="ace-icon fa fa-pencil bigger-120"></i>
						</a>
						<a data-rel="tooltip" data-original-title="Trashed"  href="'.route('admin.blogcategories.trash', $row->id).'" class="btn btn-xs btn-danger tooltip-default">
							<i class="ace-icon fa fa-trash-o bigger-120"></i>
						</a>';
				} else {
					return '
						<a data-rel="tooltip" data-original-title="Restore!" href="'.route('admin.blogcategories.restored', $row->id).'" class="btn btn-xs btn-primary tooltip-default">
							<i class="ace-icon fa fa-save bigger-120"></i>
						</a>
						<a data-rel="tooltip" data-original-title="Permanent Delete!" href="'.route('admin.blogcategories.delete', $row->id).'" class="btn btn-xs btn-danger">
							<i class="ace-icon fa fa-trash bigger-120"></i>
						</a>';
				}
			})
			// Edit column name
			->editColumn('name', function ($row) {
				$html = ($row->index) ? $row->index . '. ' . $row->name : $row->name;
				$html .= ($row->category) ? ' (<a href="'.route('admin.blogcategories.show', $row->category->id).'">'.$row->category->name.'</a>)' : '';
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
        $category = $this->categories->find($id);

		// Set data to return
	   	$data = ['row'=>$category];

	   	// Return data and view
	   	return $this->view('Blog::category_show')->data($data)->title('View Blog Category');

	}

	/**
	 * Show the form for creating new category.
	 *
	 * @return \Illuminate\View\View
	 */
	public function create()
	{
		return $this->showForm('create');
	}

	/**
	 * Handle posting of the form for creating new category.
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function store()
	{
		return $this->processForm('create');
	}

	/**
	 * Show the form for updating category.
	 *
	 * @param  int  $id
	 * @return mixed
	 */
	public function edit($id)
	{
		return $this->showForm('update', $id);
	}

	/**
	 * Handle posting of the form for updating category.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function update($id)
	{
		return $this->processForm('update', $id);
	}

	/**
	 * Remove the specified category.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function trash($id)
	{
		if ($category = $this->categories->find($id))
		{
			// Add deleted_at and not completely delete
			$category->delete();

			// Redirect with messages
			return Redirect::to(route('admin.categories.index','path=trashed'))->with('success', 'Blog Category Trashed!');
		}

		return Redirect::to(route('admin.categories.index','path=trashed'))->with('error', 'Blog Category Not Found!');
	}

	/**
	 * Restored the specified category.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function restored($id)
	{
		if ($category = $this->categories->onlyTrashed()->find($id))
		{

			// Restored back from deleted_at database
			$category->restore();

			// Redirect with messages
			return Redirect::to(route('admin.categories.index'))->with('success', 'Blog Category Restored!');
		}

		return Redirect::to(route('admin.categories.index'))->with('error', 'Blog Category Not Found!');;
	}

	/**
	 * Delete the specified category.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function delete($id)
	{
		if ($category = $this->categories->onlyTrashed()->find($id))
		{

			// Delete if there is an image attached
			if(File::exists('uploads/'.$banner->image)) {
				// Delete the single file
				File::delete('uploads/'.$banner->image);

			}

			// Completely delete from database
			$category->forceDelete();

			// Redirect with messages
			return Redirect::to(route('admin.categories.index'))->with('success', 'Blog Category Permanently Deleted!');
		}

		return Redirect::to(route('admin.categories.index'))->with('error', 'Blog Category Not Found!');
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
			if ( ! $row = $this->categories->find($id))
			{
				return Redirect::to(route('admin.categories.index'))->withErrors('Not found data!');;
			}
		}
		else
		{
			$row = $this->categories;
		}

		// Set model to form
		$model = $this->categories;

		return $this->view('Blog::category_form')->data(compact('mode','row','model'))->title('Blog Category '.$mode);
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

		// Set category slug
		$input['slug'] = isset($input['name']) ? str_slug($input['name'],'-') : '';

		$rules = [
			'name' 	   	   => 'required|max:20',
			//'slug' 		   => 'required',
			'description'  => 'required',
			'status'	   => 'boolean',
			//'image' 	   => ($mode == 'create' ? 'required|' : '').'mimes:jpg,jpeg,png|max:999',
			'index'	   	   => 'numeric|digits_between:1,999',
		];

		if ($id)
		{
			// Set default category
			$category = $this->categories->find($id);

			// Set validation messages
			$messages = $this->validateBlogCategory($input, $rules);

			// If user upload a file
			if (isset($input['image']) && Input::hasFile('image')) {

				// Set filename
				$filename = $this->imageUploadToDb($input['image'], 'uploads', 'category_');

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
				$category->update($result);
			}

		}
		else
		{

			// Set validation messages
			$messages = $this->validateBlogCategory($input, $rules);

			// If user upload a file
			if (isset($input['image']) && Input::hasFile('image')) {

				// Set filename
				$filename = $this->imageUploadToDb($input['image'], 'uploads', 'category_');

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
				$category = $this->categories->create($result);

			}
		}

		if ($messages->isEmpty())
		{
			return Redirect::to(route('admin.blogcategories.show',$category->id))->with('success', 'Blog Category Updated!');
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
				$this->categories->find($row)->update(['status' => Input::get('select_action')]);
		    }

		    // Set message
		    return Redirect::to(route('admin.categories.index'))->with('success', 'Blog Category Status Changed!');

		} else {

		    // Set message
		    return Redirect::to(route('admin.categories.index'))->with('error','Data not Available!');
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
	 		// Getting image extension
	 		$extension = $file->getClientOriginalExtension();
	 		// Renaming image
	 		$filename = $type . rand(11111,99999) . '.' . $extension;
	 		// Set intervention image for image manipulation
	 		Storage::disk('local_uploads')->put($filename,
	 			file_get_contents($file->getRealPath())
	 		);
	 		// If image has a resize crop data in constructor
	 		if (!empty($this->imgFit)) {
	 			$image = Image::make($path .'/'. $filename);
	 			foreach ($this->imgFit as $imgFit) {
	 				$size = explode('x',$imgFit);
	 				$image->fit($size[0],$size[1])->save($path .'/'. $imgFit.'px_'. $filename);
	 			}
	 		}
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
		$categories = $this->categories->select('id','name','description','status','updated_at','created_at')->get();
		// Export file to type
		Excel::create('blogcategories', function($excel) use($categories) {
			// Set the spreadsheet title, creator, and description
			$excel->setTitle('Export List');
			$excel->setCreator('Laravel')->setCompany('laravel.com');
			$excel->setDescription('export file');

			$excel->sheet('Sheet 1', function($sheet) use($categories) {
				$sheet->fromArray($categories);
			});
		})->export($type);

	}

	/**
	 * Validates a category.
	 *
	 * @param  array  $data
	 * @param  mixed  $id
	 * @return \Illuminate\Support\MessageBag
	 */
	protected function validateBlogCategory($data, $rules)
	{
		$validator = Validator::make($data, $rules);

		$validator->passes();

		return $validator->errors();
	}

}
