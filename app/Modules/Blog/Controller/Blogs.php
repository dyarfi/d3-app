<?php namespace App\Modules\Blog\Controller;

// Load Laravel classes
use Route, Request, Session, Redirect, Input, Validator, View, Image, Excel, File, Storage;
// Load main base controller
use App\Modules\BaseAdmin;
// Load main models
use App\Modules\Blog\Model\Blog,
	App\Modules\Blog\Model\BlogCategory;
// Load Datatable
use Datatables;
// User Activity Logs
use Activity;

class Blogs extends BaseAdmin {
	/**
	 * Set blogs data.
	 *
	 */
	protected $blogs;

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

		// Load blogs and get repository data from database
		$this->blogs 		= new Blog;
		$this->categories	= new BlogCategory;

		// Crop to fit image size
		$this->imgFit 		= ['400x300','1200x1200'];


		// Get the entity object
		$product = $this->blogs->find(1);

		// Through a string
		//$product->tag('foo, bar, baz');

		// Through an array
		//$product->tag([ 'foo', 'bar', 'baz' ]);
		//dd($product->tags()->get());

	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index() {

		// Get deleted count
		$deleted = $this->blogs->onlyTrashed()->get()->count();

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
			// --- datatable handler [".route('admin.blogs.index')."]--- //
				var datatable  = $('#datatable-table');
				var controller = datatable.attr('rel');

				$('#datatable-table').DataTable({
					processing: true,
					serverSide: true,
					bAutoWidth: false,
					ajax: '".route('admin.blogs.datatable')."' + ($.getURLParameter('path') ? '?path=' + $.getURLParameter('path') : ''),
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
	   	return $this->view('Blog::blog_datatable_index')
		->data($data)
		->scripts($scripts)
		->inlines($inlines)
		->title('Blog List');
	}

	/**
	 * Process datatables ajax request.
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function datatable(Request $request)
	{
		$rows = Input::get('path') === 'trashed' ? $this->blogs->with('category')->onlyTrashed()->get() : $this->blogs->with('category')->orderBy('index', 'asc')->get();

		return Datatables::of($rows)
			// Set action buttons
			->editColumn('action', function ($row) {
				if (Input::get('path') !== 'trashed') {
					return '
						<a data-rel="tooltip" data-original-title="View" title="" href="'.route('admin.blogs.show', $row->id).'" class="btn btn-xs btn-success tooltip-default">
							<i class="ace-icon fa fa-check bigger-120"></i>
						</a>
						<a data-rel="tooltip" data-original-title="Edit"  href="'.route('admin.blogs.edit', $row->id).'" class="btn btn-xs btn-info tooltip-default">
							<i class="ace-icon fa fa-pencil bigger-120"></i>
						</a>
						<a data-rel="tooltip" data-original-title="Trashed"  href="'.route('admin.blogs.trash', $row->id).'" class="btn btn-xs btn-danger tooltip-default">
							<i class="ace-icon fa fa-trash-o bigger-120"></i>
						</a>';
				} else {
					return '
						<a data-rel="tooltip" data-original-title="Restore!" href="'.route('admin.blogs.restored', $row->id).'" class="btn btn-xs btn-primary tooltip-default">
							<i class="ace-icon fa fa-save bigger-120"></i>
						</a>
						<a data-rel="tooltip" data-original-title="Permanent Delete!" href="'.route('admin.blogs.delete', $row->id).'" class="btn btn-xs btn-danger">
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
			->rawColumns(['id','name','action','status'])
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
        $blog = $this->blogs->find($id);

		// Set data to return
	   	$data = ['row'=>$blog];

	   	// Return data and view
	   	return $this->view('Blog::blog_show')->data($data)->title('View Blog');

	}

	/**
	 * Show the form for creating new blog.
	 *
	 * @return \Illuminate\View\View
	 */
	public function create()
	{
		return $this->showForm('create');
	}

	/**
	 * Handle posting of the form for creating new blog.
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function store()
	{
		return $this->processForm('create');
	}

	/**
	 * Show the form for updating blog.
	 *
	 * @param  int  $id
	 * @return mixed
	 */
	public function edit($id)
	{
		return $this->showForm('update', $id);
	}

	/**
	 * Handle posting of the form for updating blog.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function update($id)
	{
		return $this->processForm('update', $id);
	}

	/**
	 * Remove the specified blog.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function trash($id)
	{
		if ($blog = $this->blogs->find($id))
		{
			// Add deleted_at and not completely delete
			$blog->delete();

			// Log it first
			Activity::log(__FUNCTION__);

			// Redirect with messages
			return Redirect::to(route('admin.blogs.index'))->with('success', 'Blog Trashed!');
		}

		return Redirect::to(route('admin.blogs.index'))->with('error', 'Blog Not Found!');
	}

	/**
	 * Restored the specified blog.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function restored($id)
	{
		if ($blog = $this->blogs->onlyTrashed()->find($id))
		{

			// Restored back from deleted_at database
			$blog->restore();

			// Log it first
			Activity::log(__FUNCTION__);

			// Redirect with messages
			return Redirect::to(route('admin.blogs.index'))->with('success', 'Blog Restored!');
		}

		return Redirect::to(route('admin.blogs.index'))->with('error', 'Blog Not Found!');;
	}

	/**
	 * Delete the specified blog.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function delete($id)
	{
		if ($blog = $this->blogs->onlyTrashed()->find($id))
		{

			// Delete if there is an image attached
			if(File::exists('uploads/'.$blog->image)) {
				// Delete the single file
				File::delete('uploads/'.$blog->image);

			}

			// Completely delete from database
			$blog->forceDelete();

			// Log it first
			Activity::log(__FUNCTION__);

			// Redirect with messages
			return Redirect::to(route('admin.blogs.index','path=trashed'))->with('success', 'Blog Permanently Deleted!');
		}

		return Redirect::to(route('admin.blogs.index','path=trashed'))->with('error', 'Blog Not Found!');
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
			if ( ! $row = $this->blogs->with('category')->find($id))
			{
				return Redirect::to(route('admin.blogs.index'))->withErrors('Not found data!');;
			}
			$tags 		= $row->tags;
		}
		else
		{
			$row 		= $this->blogs;
			$tags 		= $this->blogs->allTags();
		}

		$model	 	= $this->blogs;

		$categories = $this->categories->pluck('name', 'id')->all();

		//$projects 	= $this->projects->pluck('name', 'id')->all();

		$tags		= $tags;

		// Load needed javascripts
		$scripts = [
			'bootstrap-tag'=>asset("themes/ace-admin/js/bootstrap-tag.min.js"),
			'bootstrap-datepicker'=>asset('themes/ace-admin/js/bootstrap-datepicker.min.js'),
			'ckeditor'=>asset('themes/ace-admin/plugins/ckeditor/ckeditor.js'),
			'library'=>asset('themes/ace-admin/js/library.js')
		];

		// Load needed stylesheets
		$styles = [
			'stylesheet-datepicker'=> asset('themes/ace-admin/css/datepicker.min.css')
		];

		return $this->view('Blog::blog_form')->data(compact('mode','row','categories','blogs','tags','model'))->scripts($scripts)->styles($styles)->title('Blog '.$mode);
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

		// Set blog slug
		$input['slug'] = isset($input['name']) ? str_slug($input['name'],'-') : '';

		$rules = [
			'category_id'  => 'required',
			'name' 	   	   => 'required',
			'excerpt' 	   => 'max:2000',
			'description'  => 'required',
			'publish_date' => 'date_format:Y-m-d|required',
			'status'	   => 'boolean',
			'image' 	   => ($mode == 'create' ? 'required|' : '').'mimes:jpg,jpeg,png|max:999',
			'index'	   	   => 'numeric|digits_between:1,999',
		];
		if ($id)
		{
			// Set default blog
			$blog 	= $this->blogs->find($id);

			// Set validation messages
			$messages 	= $this->validateBlog($input, $rules);

			// If user upload a file
			if (isset($input['image']) && Input::hasFile('image')) {

				// Set filename
				$filename = $this->imageUploadToDb($input['image'], 'uploads', 'blog_');

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
				$blog->update($result);

				// Using the `slug` column
				if($result['tags']) {
					$blog->setTags($result['tags']);
				}

			}

		}
		else
		{

			// Set validation messages
			$messages = $this->validateBlog($input, $rules);

			// If user upload a file
			if (isset($input['image']) && Input::hasFile('image')) {

				// Set filename
				$filename = $this->imageUploadToDb($input['image'], 'uploads', 'blog_');

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
				$blog = $this->blogs->create($result);

				// Using the `slug` column
				if($result['tags']) {
					$blog->setTags($result['tags']);
				}

			}
		}

		// Log it first
		Activity::log(__FUNCTION__);

		if ($messages->isEmpty())
		{
			return Redirect::to(route('admin.blogs.show', $blog->id))->with('success', 'Blog Updated!');
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
				$this->blogs->find($row)->update(['status' => Input::get('select_action')]);
		    }

		    // Set message
		    return Redirect::to(route('admin.blogs.index'))->with('success', 'Blog Status Changed!');

		} else {

		    // Set message
		    return Redirect::to(route('admin.blogs.index'))->with('error','Data not Available!');
		}
	}

	/**
	 * List Taggable data at the specified blog.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function tags($id='')
	{
		if ($id) {
			if ($blog = $this->blogs->find($id)) {
				// Return Json Response
				return response()->json($blog->tags->pluck('name'), 200);
			}
		} else {
			// Return Json Response
			return response()->json($this->blogs->allTags()->pluck('name'), 200);
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

		// Log it first
		Activity::log(__FUNCTION__);

		// Get type file to export
		$type = Input::get('rel');
		// Get data to export
		$blogs = $this->blogs->select('id','name','description','status','updated_at','created_at')->get();
		// Export file to type
		Excel::create('blogs', function($excel) use($blogs) {
			// Set the spreadsheet title, creator, and description
			$excel->setTitle('Export List');
			$excel->setCreator('Laravel')->setCompany('laravel.com');
			$excel->setDescription('export file');

			$excel->sheet('Sheet 1', function($sheet) use($blogs) {
				$sheet->fromArray($blogs);
			});
		})->export($type);

	}

	/**
	 * Validates a blog.
	 *
	 * @param  array  $data
	 * @param  mixed  $id
	 * @return \Illuminate\Support\MessageBag
	 */
	protected function validateBlog($data, $rules)
	{
		$validator = Validator::make($data, $rules);

		$validator->passes();

		return $validator->errors();
	}


}
