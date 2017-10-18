<?php namespace App\Modules\User\Controller;

// Load Laravel classes
use Route, Request, Auth, Session, Redirect, Input, Validator, View;
// Load main base controller
use App\Modules\BaseAdmin;
// Load main models
use App\Modules\User\Model\Setting, App\Modules\User\Model\User;

class Settings extends BaseAdmin {

	/**
	 * Set settings data.
	 *
	 */
	protected $settings;

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

		// Load settings and get repository data from database
		$this->settings = new Setting;

		//$subject = 'The Truth newsletter - Laravel Newsletter';
		//$contents = '<h1>Big news</h1>The world is carried by four elephants on a turtle!';

		//dd(Newsletter::createCampaign($subject, $contents));


		//Newsletter::subscribe('defrian.yarfi@gmail.com', ['firstName'=>'Havelock', 'lastName'=>'Vetinari'], 'Laravel Newsletter Page');
		//Newsletter::subscribe('dyarfi20@gmail.com', ['firstName'=>'Havelock2', 'lastName'=>'Vetinari2'], 'Laravel Newsletter Page');

		//Newsletter::unsubscribe('sam.vimes@discworld.com', ['firstName'=>'Sam', 'lastName'=>'Vines'], 'mySecondList');

		//dd(Newsletter::createCampaign($subject, $contents, 'Laravel Newsletter Page'));

		//dd(Newsletter::sendCampaign('565089'));

		//$api = Newsletter::getApi();

		//dd($api->call('campaigns/list',1));

		//$pluck = Newsletter::getApi();
		//$campaigns = element('data',$pluck);

		//dd($pluck->call('campaigns/list',true));

	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index() {

		// Set return data
	   	$settings = Input::get('path') === 'trashed' ? $this->settings->onlyTrashed()->orderBy('name')->get() : $this->settings->orderBy('name')->get();

	   	// Get deleted count
		$deleted = $this->settings->onlyTrashed()->get()->count();

	   	// Set data to return
	   	$data = ['settings' => $settings,'deleted' => $deleted,'junked' => Input::get('path'), 'config_settings' => $this->settings->setToConfig()];

		// Load needed scripts
		$scripts = [
					'library' => asset("themes/ace-admin/js/library.js")
					];

		// Return data and view
	   	return $this->view('User::settings.index')->data($data)->scripts($scripts)->title('Setting List');
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
        $setting = $this->settings->find($id);

		// Set data to return
	   	$data = ['setting'=>$setting];

	   	// Return data and view
	   	return $this->view('User::settings.show')->data($data)->title('View Setting');

	}

	/**
	 * Show the form for creating new setting.
	 *
	 * @return \Illuminate\View\View
	 */
	public function create()
	{
		return $this->showForm('create');
	}

	/**
	 * Handle posting of the form for creating new setting.
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function store()
	{
		return $this->processForm('create');
	}

	/**
	 * Show the form for updating setting.
	 *
	 * @param  int  $id
	 * @return mixed
	 */
	public function edit($id)
	{
		return $this->showForm('update', $id);
	}

	/**
	 * Handle posting of the form for updating setting.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function update($id)
	{
		return $this->processForm('update', $id);
	}

	/**
	 * Remove the specified setting.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function trash($id)
	{
		if ($setting = $this->settings->find($id))
		{
			// Add deleted_at and not completely delete
			$setting->delete();

			// Redirect with messages
			return Redirect::to(route('admin.settings.index'))->with('success', 'Setting Trashed!');
		}

		return Redirect::to(route('admin.settings.index'))->with('error', 'Setting Not Found!');
	}

	/**
	 * Restored the specified setting.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function restored($id)
	{
		if ($setting = $this->settings->onlyTrashed()->find($id))
		{

			// Restored back from deleted_at database
			$setting->restore();

			// Redirect with messages
			return Redirect::to(route('admin.settings.index'))->with('success', 'Setting Restored!');
		}

		return Redirect::to(route('admin.settings.index'))->with('error', 'Setting Not Found!');;
	}

	/**
	 * Delete the specified setting.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function delete($id)
	{
		if ($setting = $this->settings->onlyTrashed()->find($id))
		{

			// Completely delete from database
			$setting->forceDelete();

			// Redirect with messages
			return Redirect::to(route('admin.settings.index'))->with('success', 'Setting Permanently Deleted!');
		}

		return Redirect::to(route('admin.settings.index'))->with('error', 'Setting Not Found!');
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
			if ( ! $setting = $this->settings->find($id))
			{
				return Redirect::to(route('admin.settings.index'))->withErrors('Not found data!');;
			}
		}
		else
		{
			$setting = $this->settings;
		}

		// Get all group in setting database
		$groups_tmp = array_unique(head($this->settings->get()->pluck('group')));
		$groups = '';
		foreach ($groups_tmp as $tmp) {
			$groups[$tmp] = ucfirst($tmp);
		}

		// Load needed scripts
		$scripts = [
					'library' => asset("themes/ace-admin/js/library.js")
				];

		return $this->view('User::settings.form')->data(compact('mode', 'setting', 'groups'))->scripts($scripts)->title('Setting '.$mode);
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
			'name' 		   => 'required',
			'group' 	   => 'required',
			'slug' 		   => 'required',
			'input_type'   => 'required',
			'description'  => 'required',
			'value'  	   => 'required',
			'editable'	   => 'boolean',
			'status'	   => 'boolean'
		];

		if ($id)
		{

			$setting = $this->settings->find($id);

			$messages = $this->validateSetting($input, $rules);

			if ($messages->isEmpty())
			{
				$setting->update($input);
			}

		}
		else
		{

			$messages = $this->validateSetting($input, $rules);

			if ($messages->isEmpty())
			{

				$input = array_set($input, 'key', str_slug($input['name'],'.'));

				$setting = $this->settings->create($input);
			}
		}

		if ($messages->isEmpty())
		{
			return Redirect::to(route('admin.settings.show', $setting->id))->with('success', 'Setting Updated!');
		}

		return Redirect::back()->withInput()->withErrors($messages);
	}

	/**
	 * Change site setting status.
	 *
	 * @param  array  $data
	 * @param  mixed  $id
	 * @return boolean
	 */
	public function change() {

		// Catch all input post
		$input = array_filter(Input::all());

		// Validation rules
		$rules = [
			'email-contact' 		=> 'required|min:5|email',
			'email-info' 			=> 'required|min:5|email',
			'email-administrator'	=> 'required|min:5|email',
		  	'smtp-server' 			=> 'required|ip',
			'site-name' 			=> 'required|max:32',
			'site-locale' 			=> 'required|max:3',
			'site-theme' 			=> 'required',
			'site-admin-theme' 		=> 'required',
			'site-tagline' 			=> 'required',
			'site-timezone' 		=> 'required|timezone',
			'site-country' 			=> 'required',		
			'maintenance-mode'		=> 'required|in:Yes,No',	
			'socmed-facebook' 		=> 'url',
			'socmed-twitter' 		=> 'url',
			'image-logo'			=> 'image|mimes:jpg,jpeg,png|max:500kb',
			'thumbnail-size' 		=> 'required',
			'image-size' 			=> 'required',
			'meta-robots' 			=> 'required',
			'meta-keywords' 		=> 'required',
			'meta-description' 		=> 'required',
			'meta-generator' 		=> 'required',
  		];

		// Default variable checking
		$updated = false;

		// Session checking variable
		$session = base64_decode(Request::input('setting_form')) == Session::getId();

		// POST Request Method Checking
		if (Request::server('REQUEST_METHOD') === 'POST') {

		    // Check if requested contain 'access_permission'
			if (Request::has('setting_form') && $session) {

				// Validation messages
				$messages = $this->validateSetting($input, $rules);

				if ($messages->isEmpty()) {

					if (!empty($input['image-logo']) && !$input['image-logo']->getError()) {
					      $destinationPath = public_path().'/images/logo'; // upload path
						  //$extension = $input['image-logo']->getClientOriginalExtension(); // getting image extension
					      //$fileName = 'logo-'.rand(11111,99999).'.'.$extension; // renameing image
						  $fileName = $input['image-logo']->getClientOriginalName(); // renameing image
					      $input['image-logo']->move($destinationPath, $fileName); // uploading file to given path

					      // Slip image file
						  $input = array_set($input, 'image-logo', $fileName);

				    }

				    // Save the changes to database
				    foreach ($input as $key => $value) {

						if($key !== '_token') {

							$this->settings->where('slug','=', $key)->update(['value'=>$value]);

						}

					}

				}
			  	else {

			  		// Set error validation messages
			  		return Redirect::back()->withInput()->withErrors($messages);

			  	}

				// Saved checking
				$updated = true;

			} else {

				// Saved checking
				$updated = false;

			}

		} else {

			// Return response Unauthorized
			// return response()->json(['status'=>'200','message'=>'Unauthorized!']);
			return Redirect::to(route('admin.settings.index'))->with('error', 'Unauthorized!');

		}


		if ($updated) {

			// Return response successfull
			// return response()->json(['status'=>'200','message'=>'Update Successfull!']);
			return Redirect::to(route('admin.settings.index'))->with('success', 'Setting updated!');

		} else {

			// Return response failed
			// return response()->json(['status'=>'200','message'=>'Update Failed!']);
			return Redirect::to(route('admin.settings.index'))->with('error', 'Failed to update!');
		}

	}


	/**
	 * Validates a setting.
	 *
	 * @param  array  $data
	 * @param  mixed  $id
	 * @return \Illuminate\Support\MessageBag
	 */
	protected function validateSetting($data, $rules)
	{
		$validator = Validator::make($data, $rules);

		$validator->passes();

		return $validator->errors();
	}


}
