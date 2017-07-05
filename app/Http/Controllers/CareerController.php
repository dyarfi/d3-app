<?php namespace App\Http\Controllers;

//use Cartalyst\Sentinel\Checkpoints\NotActivatedException;
//use Cartalyst\Sentinel\Checkpoints\ThrottlingException;
// Load Laravel classes
//use Illuminate\Http\Request;
//use Illuminate\Routing\Controller;
use Route, Input, Request, Validator, Redirect, Session, Mail;
// Load main models
use App\Modules\Career\Model\Applicant;
use App\Modules\Career\Model\Career;
// Apps Setting model
use App\Modules\User\Model\Setting;

class CareerController extends BasePublic {

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct() {
		parent::__construct();

		// Set career object
		$this->career = new Career;
		// Set applicant object
		$this->applicant = new Applicant;

	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index() {

		// Set return data
	   	$careers = Career::active()->paginate(1);

		// Set return data
		$career_list = Career::active()->get();

	   	// Set pagination path
	   	$careers->setPath('career');

   		// Get the page path that requested
		$path = pathinfo(Request::path(), PATHINFO_BASENAME);

		// External Scripts
		$scripts = [
			'jquery-ui' => asset('js/jquery-ui-1.11.0.min.js'),
			'jquery-datepicker' => asset('js/plugins/jquery.datepicker-min.js')
		];

		// External Styles
	   	$styles 	= [
	   		'jquery-ui' => asset('css/jquery-ui.css'),
	   	];

	   	// Set data to return
	   	$data = ['careers'=>$careers,'career_list'=>$career_list,'menu'=>$this->menu->where('slug', $path)->first(),'applicant'=>$this->applicant];

	   	// Return data and view
	   	return $this->view('menus.career')->data($data)->scripts($scripts)->styles($styles)->title('Career - Laravel Careers');
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function apply()
	{
		// Setting up rules
		$input = (object) [
					'name' => '',
		          	'email' => '',
		          	'phone' => '',
		          	'image' => '',
		          	'description' => ''
		          	];

		// Set data to return
		// $career = Career::where('slug',@$slug)->first();

		//$applicant = new Applicant;
	   	$data = ['career'=>@$career,'applicant'=>$input];

		// Return view
		//return $this->view('careers.index')->data($data)->title(@$career->name . ' | Apply Careers - Laravel Careers');
		return response()->json($data);

	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function post()
	{
		// Default filename
		$fileName = '';

		// Default checker
		$uploaded = 0;

		// Catch all input post
		$input = array_filter(Input::all());

		// setting up rules
		$rules = [
				  'jobform_fname' => 'required',
				  'jobform_lname' => 'required',
				  'jobform_email' => 'required|email',
				  'jobform_phone' => 'required',
				  'jobform_birthdate' => 'date_format:Y-m-d|required',
				  'jobform_website' => 'url',
				  'jobform_position' => 'required',
				  'jobform_start' => 'date_format:Y-m-d|required',
				  'jobform_application' => 'required',
				  'jobform_cv' => 'required|mimes:zip|max:600',
			  	  'g-recaptcha-response' => 'required|captcha',
			  	];

		// doing the validation, passing post data, rules and the messages
		$validator = Validator::make($input, $rules);

		if ($validator->fails()) {
			// send back to the page with the input data and errors
			// return Redirect::to(route('career').'/'.$slug.'/apply')->withInput()->withErrors($validator);
			//dd($validator);
			//return response()->json(['response'=>false,'message'=>$validator->errors()]);
			return Redirect::to(route('career').'#content')->withInput()->withErrors($validator);
		}
		else {

			// checking file is valid.
			$fileName = '';
			if (!empty($input['jobform_cv']) && !$input['jobform_cv']->getError()) {
				$destinationPath = public_path().'/uploads'; // upload path
				$extension = $input['jobform_cv']->getClientOriginalExtension(); // getting image extension
				$fileName = rand(11111,99999).'.'.$extension; // renaming image
				$input['jobform_cv']->move($destinationPath, $fileName); // uploading file to given path
				$uploaded = 1;
				// sending back with message
				// Session::flash('success', 'Upload successfully');
				// return Redirect::to('careers/create');
			} //else {
				// sending back with error message.
				//Session::flash('error', 'uploaded file is not valid');
				//return Redirect::to('career/'.$slug.'/apply');
			//}

			$vacancy = Career::where('slug', $input['jobform_position'])->first();

			$fields = [
				'provider_id'		=> '',
				'provider'			=> '',
				'profile_url'		=> '',
				'photo_url'			=> '',
				'name' 				=> $input['jobform_fname'].' '.$input['jobform_lname'],
				'username'			=> '',
				'email' 			=> $input['jobform_email'],
				'birthdate' 		=> $input['jobform_birthdate'],
				'password' 			=> '',
				'avatar' 			=> '',
				'about' 			=> $input['jobform_application'],
				'availability_date' => $input['jobform_start'],
				'phone_number' 		=> $input['jobform_phone'],
				'phone_home'		=> '',
				'address'			=> '',
				'region'			=> '',
				'province'			=> '',
				'urban_district'	=> '',
				'sub_urban'			=> '',
				'zip_code'			=> '',
				'website'			=> $input['jobform_website'],
				'gender'			=> '',
				'age'				=> '',
				'nationality'		=> '',
				'id_number'			=> '',
				'file_name'			=> $fileName,
				'verify'			=> '',
				'completed'			=> '',
				'logged_in'			=> '',
				'last_login'		=> '',
				'attribute_id'		=> $vacancy->id,
				'session_id'		=> '',
				'join_date'			=> '',
				'status'			=> 1
			];

			// Slip vacancy fields
			$fields['vacancy'] = $vacancy->name;

			// Filter the blank values
			$fields = array_filter($fields);

			// Sent thank you email to public
		    $sent_public = Mail::send('emails.career_apply_public', $fields, function($e) use ($fields)
			    {
			     	$e->to($fields['email'])->subject('Career Apply | '.$fields['vacancy'].' - ' . url());
			    }
			);

			// Setup for website administrator email data
			$admin = Setting::where('group','email')->where('key','contact')->first();

			// Set email admin view variables
			$fields['admin_name'] = $admin->name;
			$fields['admin_email'] = $admin->value;

			// Sent thank you email to admin
		    $sent_admin = Mail::send('emails.career_apply_admin', $fields, function($ea) use ($fields)
			    {
					$ea->to($fields['admin_email'])->subject('Career Apply for '.$fields['vacancy'].' from ' . $fields['name']);
			    }
			);

			// Send message if failed
		    if ($sent_public === 0 && $sent_admin === 0)
		    {
		     	return Redirect::to('career')->withErrors('Failed to send email message.');
		    }

			// Unset unwanted fields

			// Create new applicants
			Applicant::create($fields);

			// Set session flash to user
			Session::flash('flash_message', $vacancy->name.' Career applied successfully!');

		}

		return Redirect::to(route('career'));
		//dd($input);
		// Get all request
		//$result = $input;

		// Slip image file
		//$result = is_array(@$result['image']) ? array_set($result, 'image', '') : array_set($result, 'image', $fileName);

		// Set to database if $result is true
		//Applicant::create($result);

		// Set session flash to user
		//Session::flash('flash_message', 'Career applied successfully!');

		// Set data
		//$data = ['career'=>'','applicant'=>$input];
		// Return view
		//return $this->view('careers.index')->data($data)->title(@$career->name . ' | Apply Careers - Laravel Careers');
		//return response()->json($data);

	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store($slug)
	{

		// Default filename
		$fileName = '';

	  	// Default checker
	  	$uploaded = 0;

	  	// Catch all input post
		$input = array_filter(Input::all());

		// setting up rules
		$rules = ['name' => 'required',
		          'email' => 'required|email',
		          'phone' => 'required',
		          'description' => 'required'];

		// doing the validation, passing post data, rules and the messages
  		$validator = Validator::make($input, $rules);

		if ($validator->fails()) {
		    // send back to the page with the input data and errors
		    return Redirect::to(route('career').'/'.$slug.'/apply')->withInput()->withErrors($validator);
		}
	  	else {

		    // checking file is valid.
		    if (!empty($input['image']) && !$input['image']->getError()) {
			    $destinationPath = public_path().'/uploads'; // upload path
			    $extension = $request->file('image')->getClientOriginalExtension(); // getting image extension
			    $fileName = rand(11111,99999).'.'.$extension; // renaming image
			    $input['image']->move($destinationPath, $fileName); // uploading file to given path
			    $uploaded = 1;
			    // sending back with message
			    // Session::flash('success', 'Upload successfully');
		      	// return Redirect::to('careers/create');
		    } //else {
			    // sending back with error message.
			    //Session::flash('error', 'uploaded file is not valid');
			    //return Redirect::to('career/'.$slug.'/apply');
		    //}

		}

		// Get all request
		$result = $input;

		// Slip image file
		$result = is_array(@$result['image']) ? array_set($result, 'image', '') : array_set($result, 'image', $fileName);

    	// Set to database if $result is true
    	Applicant::create($result);

    	// Set session flash to user
	    Session::flash('flash_message', 'Career applied successfully!');

	    return redirect()->back();
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  string $slug
	 * @return Response
	 */
	public function show($slug)
	{

		// Get data from database
        $career = Career::where('slug',$slug)->first();
	   	$data = ['career'=>$career];

	   	// Return data and view
	   	return $this->view('careers.show')->data($data)->title('View Careers - Careers');

	}

	/**
	 * Display the specified resource.
	 *
	 * @param  string  $slug
	 * @return Response
	 */
	public function detail($slug)
	{

		// Get data from database
		//$career = Career::where('slug',$slug)->first(['id','name','slug']);
		//$data = ['career'=>$career];

		// Return data and view
		// return $this->view('careers.show')->data($data)->title('View Careers - Laravel Careers');
		// return response()->json($career);

	}

}
