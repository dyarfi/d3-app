<?php namespace App\Http\Controllers;

// Load Laravel classes
use Request, Input, Validator, Redirect;

// Load main models
use App\Modules\User\Model\Contact;

class ContactController extends BasePublic {

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct() {
		parent::__construct();

		// Set contact object
		$this->contact = new Contact;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		// Get the page path that requested
		$path = pathinfo(Request::path(), PATHINFO_BASENAME);

		// Set scripts
		$scripts = [
			'google-map-api' => 'https://maps.google.com/maps/api/js?key=AIzaSyBKhz0m2SnwvXZUX3moyc2WYq7PfS3tpLk',
			'jquery-gmap' => asset("js/jquery.gmap.js"),
			'gmaps' => asset('js/gmaps.js')
		];
		// Set data to return
	   	$data = ['menu'=>$this->menu->where('slug', $path)->first(),'contact'=>$this->contact];

	   	// Return data and view
	   	return $this->view('contacts.form')->scripts($scripts)->data($data)->title('Page | Contact');
	}

	/**
	 * Send Email Contact.
	 *
	 * @return Response
	 */
	public function sendContact()
	{
 		$data = Input::all();

	    $rules = array(
		  	'contactform_name' => 'required',
		  	'contactform_email' => 'required|email',
			'contactform_subject' => 'required',
			'contactform_phone' => 'required',
			'contactform_message' => 'required',
			'g-recaptcha-response' => 'required|captcha',
		);

		$validator = Validator::make($data, $rules);

		if ($validator->fails()){

		    return Redirect::to(route('contact'))->withInput()->withErrors($validator);
		}
		else{
		    // Do your stuff.
		}

	}

}
