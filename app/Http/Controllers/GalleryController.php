<?php namespace App\Http\Controllers;

use Cartalyst\Sentinel\Checkpoints\NotActivatedException;
use Cartalyst\Sentinel\Checkpoints\ThrottlingException;
// Load Laravel classes
use Auth, Route, Request, Input, Validator, Redirect, Session, Image;
// Load main models
use App\Modules\Participant\Model\Participant;
use App\Modules\Participant\Model\Image as ImageParticipant;

class GalleryController extends BasePublic {

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct() {
		parent::__construct();

		// Image Participant Model
		$this->ImageParticipant = new ImageParticipant;
		// Participant Model
		$this->participant = new Participant;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index() {

		// Set return data
	   	$images = $this->ImageParticipant->active()->orderBy('created_at','desc')->paginate(2);

	   	// Set pagination path
	   	$images->setPath('gallery');

	   	// Get the page path that requested
		$path = pathinfo(Request::path(), PATHINFO_BASENAME);

	   	// Set data to return
	   	$data = ['images'=>$images,'menu'=>$this->menu->where('slug', $path)->first()];

	   	// Set javascripts and stylesheets
	   	$scripts 	= [
	   		'jquery.colorbox' => asset('themes/ace-admin/js/jquery.colorbox.min.js'),
	   	];
	   	$styles 	= [
	   		'jquery.colorbox' => asset('themes/ace-admin/css/colorbox.min.css'),
	   	];

	   	// Return data and view
	   	return $this->view('gallery.index')->data($data)->scripts($scripts)->styles($styles)->title('Gallery - Laravel Gallery');
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function upload() {

		// Setting up rules
		$input = (object) [
					'name' => '',
		          	'email' => '',
		          	'phone' => '',
		          	'image' => '',
		          	'description' => ''
		          	];

		// Get the page directory path that requested
		$path = pathinfo(Request::path(), PATHINFO_DIRNAME);

		// Set data to return
		$images = $this->ImageParticipant;

		// Load fabric js library
		$scripts = [
			// Jquery File Upload
			'jquery.ui.widget' => asset('js/jquery-file-upload/js/jquery.ui.widget.min.js'),
			'jquery.iframe-transport' => asset('js/jquery-file-upload/js/jquery.iframe-transport.js'),
			'jquery.fileupload' => asset('js/jquery-file-upload/js/jquery.fileupload.js'),
			'jquery.fileupload-process' => asset('js/jquery-file-upload/js/jquery.fileupload-process.js'),
			'jquery.fileupload-validate' => asset('js/jquery-file-upload/js/jquery.fileupload-validate.js'),
			'jquery.fileupload-ui' => asset('js/jquery-file-upload/js/jquery.fileupload-ui.js'),
			'jquery.iframe-transport' => asset('js/jquery-file-upload/js/jquery.iframe-transport.js'),

			// Jquery colorpicker
			'jqueryminicolors' => asset('js/fabric.js/jquery.miniColors.min.js'),

			// Jquery Fabric JS
			'canvas2image.' => asset('js/fabric.js/canvas2image.js'),
			'fabric-1.6' => asset('js/fabric.js/fabric-1.6.0-rc.1.min.js'),
			'aligning_guidelines' => asset('js/fabric.js/aligning_guidelines.js'),
			'centering_guidelines' => asset('js/fabric.js/centering_guidelines.js'),
			'client' => asset('js/fabric.js/client.js')
		];

		$styles = [
			'simplecolorpicker' => asset('css/jquery.simplecolorpicker.css'),
			'jquery.miniColors' => asset('css/jquery.miniColors.css'),
			// Main styles for fabric js gallery
			'gallery' => asset('css/gallery.css'),
		];

		// Set data to views
	   	$data = ['images'=>$images,'participant'=>@$participant,'menu'=>$this->menu->where('slug', $path)->first()];

		// Return view
		return $this->view('gallery.form')->data($data)->scripts($scripts)->styles($styles)->title('Upload Images - Laravel Gallery');

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
    	$this->ImageParticipant->create($result);

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
        $image = $this->ImageParticipant->where('slug',$slug)->first();
	   	$data = ['image'=>$image];

	   	// Return data and view
	   	return $this->view('image.show')->data($data)->title('View Images - Laravel Images');

	}

	/**
	 * Display the specified resource.
	 *
	 * @return JSON Response
	 */

	public function response() {

		$data = Input::all();

		// Detect if data sent by POST
        if(Request::ajax() && Request::isMethod('post'))
        {
			// Get the data sent and replace unwanted string
			$base64img = str_replace('data:image/png;base64,', '', $data["data"]);
			$base64img = str_replace('data:image/jpeg;base64,', '', $base64img);

			// Decode base64 data sent
			$return = base64_decode($base64img);
			$filename = uniqid() . '.png';

			// Generate unique image name
			$file = 'uploads/' . $filename;

			// Default result empty variable
			$result = '';

			// Put file to upload directory
	    	if (file_put_contents($file, $return)) {

    			// Send success message
				$result['result']['code'] = 1;
				$result['result']['text'] = 'Success';
				$result['result']['file'] = $file;

				$object['participant_id'] 	= Auth::user()->id;
				$object['type'] 			= $data["type"];
				$object['file_name']		= $filename;
				$object['status'] 			= 1;

				$this->ImageParticipant->create($object);


	    	} else {

				// Send fail message
				$result['result']['code'] = 0;
				$result['result']['text'] = 'Failed';
				$result['result']['file'] = '';

	    	}

			// Return data esult
			//$data['json'] = $result;

			// Load data into view
			//$this->load->view('json', $this->load->vars($data));
			return response()->json($result);

		}

	}

}
