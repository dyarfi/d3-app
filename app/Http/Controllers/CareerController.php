<?php namespace App\Http\Controllers;

use Cartalyst\Sentinel\Checkpoints\NotActivatedException;
use Cartalyst\Sentinel\Checkpoints\ThrottlingException;
// Load Laravel classes
use Route, Request, Input, Validator, Redirect, Session;
// Load main models
use App\Modules\Career\Model\Applicant;
use App\Modules\Career\Model\Career;

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

	   	// Set data to return
	   	$data = ['careers'=>$careers,'career_list'=>$career_list,'menu'=>$this->menu->where('slug', $path)->first(),'applicant'=>$this->applicant];

	   	// Return data and view
	   	return $this->view('careers.index')->data($data)->title('Career - Laravel Careers');
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function apply($slug)
	{

		// setting up rules
		$input = (object) [
					'name' => '',
		          	'email' => '',
		          	'phone' => '',
		          	'image' => '',
		          	'description' => ''
		          	];

		// Set data to return
		$career = Career::where('slug',$slug)->first();

		//$applicant = new Applicant;
	   	$data = ['career'=>$career,'applicant'=>$input];

		// Return view
		return $this->view('careers.form')->data($data)->title(@$career->name . ' | Apply Careers - Laravel Careers');

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
	 * @param  int  $id
	 * @return Response
	 */
	public function show($slug)
	{

		// Get data from database
        $career = Career::where('slug',$slug)->first();
	   	$data = ['career'=>$career];

	   	// Return data and view
	   	return $this->view('careers.show')->data($data)->title('View Careers - Laravel Careers');

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
