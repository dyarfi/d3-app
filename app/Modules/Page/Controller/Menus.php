<?php namespace App\Modules\Page\Controller;

// Load Laravel classes
use Route, Request, Sentinel, Session, Redirect, Input, Validator, View;
// Load main base controller
use App\Modules\BaseAdmin;
// Load main models
use App\Modules\Page\Model\Menu;

class Menus extends BaseAdmin {

	/**
	 * Set menus data.
	 *
	 */
	protected $menus;

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

		// Load menus and get repository data from database
		$this->menus = new Menu;

	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index() {

		// Set return data
	   	$menus = Input::get('path') === 'trashed' ? $this->menus->onlyTrashed()->get() : $this->menus->orderBy('index', 'asc')->get();

	   	// Get deleted count
		$deleted = $this->menus->onlyTrashed()->get()->count();

	   	// Set data to return
	   	$data = ['rows' => $menus,'deleted' => $deleted,'junked' => Input::get('path')];

	   	// Load needed scripts
	   	$scripts = [
	   				'dataTables'=> 'themes/ace-admin/js/jquery.dataTables.min.js',
	   				'dataTableBootstrap'=> 'themes/ace-admin/js/jquery.dataTables.bootstrap.min.js',
	   				'dataTableTools'=> 'themes/ace-admin/js/dataTables.tableTools.min.js',
	   				'dataTablesColVis'=> 'themes/ace-admin/js/dataTables.colVis.min.js'
	   				];

		// Return data and view
	   	return $this->view('Page::menu_index')->data($data)->scripts($scripts)->title('Menu List');
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
        $menu = $this->menus->find($id);

		// Set data to return
	   	$data = ['row'=>$menu];

	   	// Return data and view
	   	return $this->view('Page::menu_show')->data($data)->title('View Menu');

	}

	/**
	 * Show the form for creating new menu.
	 *
	 * @return \Illuminate\View\View
	 */
	public function create()
	{
		return $this->showForm('create');
	}

	/**
	 * Handle posting of the form for creating new menu.
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function store()
	{
		return $this->processForm('create');
	}

	/**
	 * Show the form for updating menu.
	 *
	 * @param  int  $id
	 * @return mixed
	 */
	public function edit($id)
	{
		return $this->showForm('update', $id);
	}

	/**
	 * Handle posting of the form for updating menu.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function update($id)
	{
		return $this->processForm('update', $id);
	}

	/**
	 * Remove the specified menu.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function trash($id)
	{
		if ($menu = $this->menus->find($id))
		{
			// Add deleted_at and not completely delete
			$menu->delete();

			// Redirect with messages
			return Redirect::to(route('admin.menus.index'))->with('success', 'Menu Trashed!');
		}

		return Redirect::to(route('admin.menus.index'))->with('error', 'Menu Not Found!');
	}

	/**
	 * Restored the specified menu.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function restored($id)
	{
		if ($menu = $this->menus->onlyTrashed()->find($id))
		{

			// Restored back from deleted_at database
			$menu->restore();

			// Redirect with messages
			return Redirect::to(route('admin.menus.index'))->with('success', 'Menu Restored!');
		}

		return Redirect::to(route('admin.menus.index'))->with('error', 'Menu Not Found!');;
	}

	/**
	 * Delete the specified menu.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function delete($id)
	{
		if ($menu = $this->menus->onlyTrashed()->find($id))
		{

			// Completely delete from database
			$menu->forceDelete();

			// Redirect with messages
			return Redirect::to(route('admin.menus.index'))->with('success', 'Menu Permanently Deleted!');
		}

		return Redirect::to(route('admin.menus.index'))->with('error', 'Menu Not Found!');
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
			if ( ! $row = $this->menus->find($id))
			{
				return Redirect::to(route('admin.menus.index'))->withErrors('Not found data!');;
			}
		}
		else
		{
			$row = $this->menus;
		}

		return $this->view('Page::menu_form')->data(compact('mode', 'row'))->title('Menu '.$mode);
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

		// Set menu slug
		$input['slug'] = isset($input['name']) ? str_slug($input['name'],'_') : '';

		$rules = [
			'name' 	   	   => 'required',
			//'slug' 		   => 'required',
			'description'  => 'required',
			'status'	   => 'boolean',
			'image' 	   => 'required|mimes:jpg,jpeg,png|max:800',
			'index'	   	   => 'numeric|digits_between:1,999',
		];

		if ($id)
		{
			$menu = $this->menus->find($id);

			$messages = $this->validateMenu($input, $rules);

			/*
			// checking file is valid.
		    //if ($request->file('image') && $request->file('image')->isValid()) {
			if (!empty($input['image']) && !$input['image']->getError()) {
		      $destinationPath = public_path().'/uploads'; // upload path
		      $extension = $input['image']->getClientOriginalExtension(); // getting image extension
		      $fileName = rand(11111,99999).'.'.$extension; // renameing image
		      $input['image']->move($destinationPath, $fileName); // uploading file to given path
		      // sending back with message
		      //Session::flash('success', 'Upload successfully');
		      //return Redirect::to(route('admin.apanel.menus.create'));
		    }
		    else {
			      // sending back with error message.
			      // Session::flash('error', 'uploaded file is not valid');
			      // return Redirect::to('menus/'.$id.'/edit');
		    	  $fileName = old('image') ? old('image') : $menu->image;
		    }
			*/
			//dd($input);
			$fileName = '';
			if (!empty($input['image']) && !$input['image']->getError()) {
				$destinationPath = public_path().'/uploads'; // upload path
				$extension = $input['image']->getClientOriginalExtension(); // getting image extension
				$fileName = rand(11111,99999).'_menu.'.$extension; // renaming image
				$input['image']->move($destinationPath, $fileName); // uploading file to given path
				$uploaded = 1;
				// sending back with message
				// Session::flash('success', 'Upload successfully');
				// return Redirect::to('careers/create');
			}

			if ($messages->isEmpty())
			{
				// Get all request
				$result = $input;

				// Slip user id
				$result = array_set($result, 'user_id', $this->user->id);

				// Slip image file
				$result = array_set($result, 'image', @$fileName);

				$menu->update($result);
				//$menu->update($input);
			}

		}
		else
		{
			$messages = $this->validateMenu($input, $rules);
			/*
			// checking file is valid.
		    if (!empty($input['image']) && !$input['image']->getError()) {
		      $destinationPath = public_path().'/uploads'; // upload path
		      $extension = $input['image']->getClientOriginalExtension(); // getting image extension
		      $fileName = rand(11111,99999).'.'.$extension; // renameing image
		      $input['image']->move($destinationPath, $fileName); // uploading file to given path
		      // sending back with message
		      //Session::flash('success', 'Upload successfully');
		      //return Redirect::to(route('admin.apanel.menus.create'));
		    }
		    else {
		      // sending back with error message.
		      Session::flash('error', 'uploaded file is not valid');
		      return Redirect::to(route('admin.menus.create'));
		    }
			*/
			// checking file is valid.
			$fileName = '';
			if (!empty($input['image']) && !$input['image']->getError()) {
				$destinationPath = public_path().'/uploads'; // upload path
				$extension = $input['image']->getClientOriginalExtension(); // getting image extension
				$fileName = rand(11111,99999).'.'.$extension; // renaming image
				$input['image']->move($destinationPath, $fileName); // uploading file to given path
				$uploaded = 1;
				// sending back with message
				// Session::flash('success', 'Upload successfully');
				// return Redirect::to('careers/create');
			}

			if ($messages->isEmpty())
			{
				// Get all request
				$result = $input;

				// Slip user id
				$result = array_set($result, 'user_id', $this->user->id);

				// Slip image file
				$result = isset($result['image']) ? array_set($result, 'image', '') : array_set($result, 'image', @$fileName);

				//$menu = $this->menus->create($input);
				$menu = $this->menus->create($result);

			}
		}

		if ($messages->isEmpty())
		{
			return Redirect::to(route('admin.menus.show', $menu->id))->with('success', 'Menu Updated!');
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
				$this->menus->find($row)->update(['status' => Input::get('select_action')]);
		    }

		    // Set message
		    return Redirect::to(route('admin.menus.index'))->with('success', 'Menu Status Changed!');

		} else {

		    // Set message
		    return Redirect::to(route('admin.menus.index'))->with('error','Data not Available!');
		}
	}

	/**
	 * Validates a menu.
	 *
	 * @param  array  $data
	 * @param  mixed  $id
	 * @return \Illuminate\Support\MessageBag
	 */
	protected function validateMenu($data, $rules)
	{
		$validator = Validator::make($data, $rules);

		$validator->passes();

		return $validator->errors();
	}


}
