<?php namespace App\Modules\User\Controller;

// Load Laravel classes
use Route, Request, Session, Redirect, Activation, Sentinel, Input, Validator, View, Excel, File;
// Load main base controller
use App\Modules\BaseAdmin;
// Load main models
use App\Modules\User\Model\Role;
use App\Modules\User\Model\User;

class Users extends BaseAdmin {

	/**
	 * Holds the Sentinel Users repository.
	 *
	 * @var \Cartalyst\Sentinel\Users\EloquentUser
	 */
	protected $users;

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
		//$this->middleware('auth.admin');
		$this->middleware('auth.admin',['except'=>['profile','crop']]);

		// Load users and get repository data from Sentinel
		$this->users = new User;

		$this->roles = new Role;

	}

	/**
	 * Display a listing of users.
	 *
	 * @return \Illuminate\View\View
	 */
	public function index()
	{

	   	//dd ($this->users->find(1)->roles);

		// Set return data
	   	$users = Input::get('path') === 'trashed' ? $this->users->onlyTrashed()->get() : $this->users->get();

	   	// Get deleted count
		$deleted = $this->users->onlyTrashed()->get()->count();

	   	// Set data to return
	   	$data = ['rows'=>$users,'deleted'=>$deleted,'junked'=>Input::get('path')];

   		// Load needed scripts
	   	$scripts = [
	   				'dataTables'=> asset('themes/ace-admin/js/jquery.dataTables.min.js'),
	   				'dataTableBootstrap'=> asset('themes/ace-admin/js/jquery.dataTables.bootstrap.min.js'),
	   				'dataTableTools'=> asset('themes/ace-admin/js/dataTables.tableTools.min.js'),
	   				'dataTablesColVis'=> asset('themes/ace-admin/js/dataTables.colVis.min.js'),
					'library' => asset('themes/ace-admin/js/library.js')
	   				];

	   	return $this->view('User::sentinel.users.index')->data($data)->scripts($scripts)->title('User List');
	}

	/**
	 * Display user profile of the resource.
	 *
	 * @return Response
	 */
	public function profile() {

		// Check if the user logged or redirect to
		if (!Sentinel::check()) {

			return Redirect::to(route('admin.login'))->with('error', 'User not found, please login again!');

		}

		// Set return data
	   	$user = Sentinel::getUser() ? User::find($this->user->id) : '';

	   	// Set data to return
	   	$data = ['row'=>$user];

	   	// Load needed scripts
	   	$scripts = [
	   				'jcolor'=> asset('themes/ace-admin/plugins/jcrop/js/jquery.color.js'),
	   				'jcrop'=> asset('themes/ace-admin/plugins/jcrop/js/jquery.Jcrop.min.js'),
	   				'jcrop-form-image'=> asset('themes/ace-admin/plugins/jcrop/js/form-image-crop.js'),
					'library' => asset('themes/ace-admin/js/library.js')
	   				];

		// Load needed styles
	   	$styles = [
	   				'jcrop'=> asset('themes/ace-admin/plugins/jcrop/css/jquery.Jcrop.min.css'),
	   				'imageCrop'=> asset('themes/ace-admin/plugins/jcrop/css/image-crop.css')
	   				];

	   	// Return data and view
	   	return $this->view('User::sentinel.users.profile')->data($data)->scripts($scripts)->styles($styles)->title('User Profile');
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
        $user = $this->users->findOrFail($id);

        // Read ACL settings config for any permission access
        $acl = config('setting.acl');

		// Set data to return
	   	$data = ['row'=>$user,'acl'=>$acl];

	   	// Return data and view
	   	return $this->view('User::sentinel.users.show')->data($data)->title('View User');

	}

	/**
	 * Show the form for creating new user.
	 *
	 * @return \Illuminate\View\View
	 */
	public function create()
	{
		return $this->showForm('create');
	}

	/**
	 * Handle posting of the form for creating new user.
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function store()
	{
		return $this->processForm('create');
	}

	/**
	 * Show the form for updating user.
	 *
	 * @param  int  $id
	 * @return mixed
	 */
	public function edit($id)
	{
		return $this->showForm('update', $id);
	}

	/**
	 * Handle posting of the form for updating user.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function update($id)
	{
		return $this->processForm('update', $id);
	}

	/**
	 * Remove the specified user.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function trash($id)
	{
		if ($user = $this->users->find($id))
		{

			// Add deleted_at and not completely delete
			$user->delete();

			// Redirect with messages
			return Redirect::to(route('admin.users.index'))->with('success', 'User Trashed!');
		}

		return Redirect::to(route('admin.users.index'))->with('error', 'User Not Found!');
	}

	/**
	 * Restored the specified user.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function restored($id)
	{
		if ($user = $this->users->onlyTrashed()->find($id))
		{

			// Restored back from deleted_at database
			$user->restore();

			// Redirect with messages
			return Redirect::to(route('admin.users.index'))->with('success', 'User Restored!');
		}

		return Redirect::to(route('admin.users.index'))->with('error', 'User Not Found!');
	}
	/**
	 * Remove the specified user.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function delete($id)
	{

		// Get user from id fetch
		if ($user = $this->users->onlyTrashed()->find($id))
		{

			// Delete from pivot table many to many
			$this->users->onlyTrashed()->find($id)->roles()->detach();

			// Delete if there is an image attached
			if(File::exists('uploads/'.$user->image)) {
				// Delete the single file
				File::delete('uploads/'.$user->image);

			}

			// Permanently delete
			$user->forceDelete();

			return Redirect::to(route('admin.users.index','path=trashed'))->with('success', 'User Permanently Deleted!');
		}

		return Redirect::to(route('admin.users.index','path=trashed'))->with('error', 'User Not Found!');
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
			if ( ! $row = $this->users->find($id))
			{
				return Redirect::to(route('admin.users'));
			}
		}
		else
		{
			$row = Sentinel::getUserRepository()->createModel();
		}

		$roles = array_merge(['0'=>' -- NO ROLE -- '], $this->roles->lists('name', 'id')->all());

		return $this->view('User::sentinel.users.form')->data(compact('mode', 'row', 'roles'))->title('User '.$mode);
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
			'image' 	 => ($mode == 'update') ? '' : 'image|mimes:jpg,jpeg|max:500kb',
			'email'      => ($id) ? 'email|required' : 'email|required|unique:users'
		];

		// This is where the user update their account profile in the account admin.account route
		if (isset($input['_private'])) {

			list($csrf, $email, $role_id) = explode('::', base64_decode($input['_private']));

			if ($csrf == $input['_token']) {

				$input['role_id'] 	=  $role_id;
				$input['email'] 	=  $email;

			}

			$id = $this->user->id;

		}

		if ($id)
		{

			$user = Sentinel::getUserRepository()->createModel()->find($id);

			$messages = $this->validateUser($input, $rules);

			if ($messages->isEmpty())
			{

				if (!empty($input['image']) && Input::hasFile('image')) {
				      $destinationPath = public_path().'/uploads'; // upload path
				      $extension = $input['image']->getClientOriginalExtension(); // getting image extension
				      $fileName = 'usr-'.rand(11111,99999).'.'.$extension; // renameing image
				      $input['image']->move($destinationPath, $fileName); // uploading file to given path

				      // Slip image file
					  $input = array_set($input, 'image', $fileName);

			    }

				if ( ! $user->roles()->first() ) {

					// Syncing relationship Many To Many // Create New
					$user->roles()->sync(['role_id'=>$input['role_id']]);

				} else {

					// Syncing relationship Many To Many // Update Existing
					$user->roles()->sync(['role_id'=>$input['role_id']]);

					if (isset($input['_private'])) {

						// Get user model to update other profile data
						User::find($id)->update($input);

						return Redirect::back()->withInput()->with('success', 'Profile Updated!');

					} else {

						// Unset csrf token
						unset($input['_token']);

						// Update user model data
						User::find($id)->update($input);

					}

				}

			}
		}
		else
		{

			$messages = $this->validateUser($input, $rules);

			if ($messages->isEmpty())
			{
				if (!empty($input['image']) && Input::hasFile('image')) {
				      $destinationPath = public_path().'/uploads'; // upload path
				      $extension = $input['image']->getClientOriginalExtension(); // getting image extension
				      $fileName = 'usr-'.rand(11111,99999).'.'.$extension; // renameing image
				      $input['image']->move($destinationPath, $fileName); // uploading file to given path

				      // Slip image file
					  $input = array_set($input, 'image', $fileName);

			    }

				// Create user into the database
				$user = Sentinel::getUserRepository()->create($input);

				// Syncing relationship Many To Many // Create New
				$user->roles()->sync(['role_id'=>$input['role_id']]);

				$code = Activation::create($user);

				Activation::complete($user, $code);
			}
		}

		if ($messages->isEmpty())
		{
			return Redirect::to(route('admin.users.show', $user->id))->with('success', 'User Updated!');
		}

		return Redirect::back()->withInput()->withErrors($messages);
	}

	/**
	 * Validates a user.
	 *
	 * @param  array  $data
	 * @param  mixed  $id
	 * @return \Illuminate\Support\MessageBag
	 */
	protected function validateUser($data, $rules)
	{
		$validator = Validator::make($data, $rules);

		$validator->passes();

		return $validator->errors();
	}

	/**
	 * Show the dashboard for current users
	 *
	 * @param  null
	 * @return Response
	 */
	public function dashboard() {

		//dd ($this->user);

		// Set return data
	   	$user = $this->user;

	   	//dd($user);

	   	// Set data to return
	   	$data = ['user'=>$user];

	   	$scripts = ['easypiechart'=>'themes/ace-admin/js/jquery.easypiechart.min.js',
    				'sparkline' => 'themes/ace-admin/js/jquery.sparkline.min.js',
    				'jqueryflot' => 'themes/ace-admin/js/jquery.flot.min.js',
    				'jqueryflotpie'=>'themes/ace-admin/js/jquery.flot.pie.min.js',
    				'jqueryflotresize'=>'themes/ace-admin/js/jquery.flot.resize.min.js'];


	   	// Return data and view
	   	return $this->view('User::sentinel.users.dashboard')->data($data)->scripts($scripts)->title('User Dashboard');
	}

	public function export() {

		// Get type file to export
		$type = Input::get('rel');
		// Get data to export
		$users = $this->users->select('id', 'username', 'email', 'created_at')->get();
		// Export file to type
		Excel::create('users', function($excel) use($users) {
			// Set the spreadsheet title, creator, and description
	        $excel->setTitle('Export List');
	        $excel->setCreator('Laravel')->setCompany('laravel.com');
	        $excel->setDescription('export file');

		    $excel->sheet('Sheet 1', function($sheet) use($users) {
		        $sheet->fromArray($users);
		    });
		})->export($type);

	}

	public function crop($id='') {
		/**
		 * Jcrop image cropping plugin for jQuery
		 * Example cropping script
		 * @copyright 2008-2009 Kelly Hallman
		 * More info: http://deepliquid.com/content/Jcrop_Implementation_Theory.html
		 */
		$input = array_filter(Input::all());

		if (Request::ajax() && Request::isMethod('get'))
		{

			// Width and height size 100x100px
			$targ_w = $targ_h = 100;
			$jpeg_quality = 100;

			// Check if user existed
			if(!$user = $this->users->where('image',$input['image'])->firstOrFail()) {

				return Redirect::back()->withInput()->withErrors('User not found');
			}

			// Update the user's data attributes
			$options = (array) $user->attributes;
			$attribs = ['width'=>$targ_w, 'height'=> $targ_h, 'crop_x' => @$input['crop_x'],'crop_y' => @$input['crop_y'], 'crop_w' => @$input['crop_w'], 'crop_h' => @$input['crop_h']];
			$user->attributes = array_merge($options,$attribs);
			$user->save();

			// Set source file image
			$src  = $input['path'].'/'.$input['image'];

			// Set cropped file image
			$crop = pathinfo($input['path'].'/'.$input['image']);
			$file = $crop['dirname'].'/'.$crop['filename'].'-100x100px.'.$crop['extension'];

			$img_r = imagecreatefromjpeg($src);
			$dst_r = ImageCreateTrueColor( $targ_w, $targ_h );

			imagecopyresampled($dst_r,$img_r,0,0, @$input['crop_x'], @$input['crop_y'],
			$targ_w,$targ_h, @$input['crop_w'], @$input['crop_h']);
			// Sent it to browser if you just want to display
			// header('Content-type: image/jpeg');
			imagejpeg($dst_r,$file,$jpeg_quality);
			exit;
		}
	}

}
