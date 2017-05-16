<?php namespace App\Modules\Page\Controller;

// Load Laravel classes
use Route, Request, Sentinel, Session, Redirect, Input, Validator, View;
// Load main base controller
use App\Modules\BaseAdmin;
// Load main models
use App\Modules\Page\Model\Menu, App\Modules\Page\Model\Page;

class Pages extends BaseAdmin {

	/**
	 * Holds the Sentinel Pages repository.
	 *
	 * @var \Cartalyst\Sentinel\Pages\EloquentPage
	 */
	public $pages;

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

		// Load pages and get repository data from Sentinel
		$this->pages = new Page;
		$this->menus = new Menu;

	}

	/**
	 * Display a listing of pages.
	 *
	 * @return \Illuminate\View\View
	 */
	public function index()
	{

	   	//dd ($this->pages->find(1)->roles);
		
		// Set return data 
	   	$pages = Input::get('path') === 'trashed' ? $this->pages->onlyTrashed()->paginate(4) : $this->pages->paginate(4);

	   	// Get deleted count
		$deleted = $this->pages->onlyTrashed()->get()->count();
	   	
	   	// Set data to return
	   	$data = ['rows'=>$pages,'deleted'=>$deleted,'junked'=>Input::get('path')];

  		// Load needed scripts
	   	$scripts = [
	   				'dataTables'=> 'themes/ace-admin/js/jquery.dataTables.min.js',
	   				'dataTableBootstrap'=> 'themes/ace-admin/js/jquery.dataTables.bootstrap.min.js',
	   				'dataTableTools'=> 'themes/ace-admin/js/dataTables.tableTools.min.js',
	   				'dataTablesColVis'=> 'themes/ace-admin/js/dataTables.colVis.min.js'
	   				];

	   	return $this->view('Page::page_index')->data($data)->scripts($scripts)->title('Pages List');
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
        $page = $this->pages->findOrFail($id);

		// Set data to return
	   	$data = ['row'=>$page];

	   	// Return data and view
	   	return $this->view('Page::page_show')->data($data)->title('View Page'); 

	}

	/**
	 * Show the form for creating new page.
	 *
	 * @return \Illuminate\View\View
	 */
	public function create()
	{
		return $this->showForm('create');
	}

	/**
	 * Handle posting of the form for creating new page.
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function store()
	{
		return $this->processForm('create');
	}

	/**
	 * Show the form for updating page.
	 *
	 * @param  int  $id
	 * @return mixed
	 */
	public function edit($id)
	{	
		return $this->showForm('update', $id);
	}

	/**
	 * Handle posting of the form for updating page.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function update($id)
	{
		return $this->processForm('update', $id);
	}

	/**
	 * Remove the specified page.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function trash($id)
	{
		if ($page = $this->pages->find($id))
		{
			
			// Add deleted_at and not completely delete
			$page->delete();
			
			// Redirect with messages
			return Redirect::to(route('admin.pages.index'))->with('success', 'Page Trashed!');
		}

		return Redirect::to(route('admin.pages.index'))->with('error', 'Page Not Found!');
	}

	/**
	 * Restored the specified page.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function restored($id)
	{
		if ($page = $this->pages->onlyTrashed()->find($id))
		{

			// Restored back from deleted_at database
			$page->restore();

			// Redirect with messages
			return Redirect::to(route('admin.pages.index'))->with('success', 'Page Restored!');
		}

		return Redirect::to(route('admin.pages.index'))->with('error', 'Page Not Found!');
	}
	/**
	 * Remove the specified page.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function delete($id)
	{

		// Get page from id fetch
		if ($page = $this->pages->onlyTrashed()->find($id))
		{

			// Delete from pivot table many to many
			$this->pages->onlyTrashed()->find($id)->roles()->detach();

			// Permanently delete
			$page->forceDelete();

			return Redirect::to(route('admin.pages.index'))->with('success', 'Page Permanently Deleted!');
		}

		return Redirect::to(route('admin.pages.index'))->with('error', 'Page Not Found!');
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
			if ( ! $row = $this->pages->find($id))
			{
				return Redirect::to(route('admin.pages.index'));
			}
		}
		else
		{
			$row = $this->pages;
		}

		$menus = $this->menus->lists('name', 'id')->all();
		
		return $this->view('Page::page_form')->data(compact('mode', 'row', 'menus'))->title('Page '.$mode);
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
			'menu_id' => 'required',
			'name'  => 'required',
			'description' => 'required',
			'status' => 'required'
		];
		
		if ($id)
		{

			$page = $this->pages->find($id);			
			$messages = $this->validatePage($input, $rules);

			if ($messages->isEmpty())
			{

				// Update page model data
				$page->update($input);				
				
			}
		}
		else
		{
			
			$messages = $this->validatePage($input, $rules);

			if ($messages->isEmpty())
			{
				// Create page into the database
				$page = $this->pages->create($input);
								
			}
		}

		if ($messages->isEmpty())
		{
			return Redirect::to(route('admin.pages.index'))->with('success', 'Page Updated!');;
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
				$this->pages->find($row)->update(['status' => Input::get('select_action')]);
		    }

		    // Set message
		    return Redirect::to(route('admin.pages.index'))->with('success', 'Page Status Changed!');

		} else {	

		    // Set message
		    return Redirect::to(route('admin.pages.index'))->with('error','Data not Available!');
		}
	}

	/**
	 * Validates a page.
	 *
	 * @param  array  $data
	 * @param  mixed  $id
	 * @return \Illuminate\Support\MessageBag
	 */
	protected function validatePage($data, $rules)
	{
		$validator = Validator::make($data, $rules);

		$validator->passes();

		return $validator->errors();
	}

}