<?php namespace App\Http\Controllers;

// Load Laravel classes
use Request, Input, Validator, Redirect, Session;

// Load main models
use App\Modules\Contact\Model\Contact;

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
 		$input = Input::all();

	    $rules = array(
		  	'contactform_name' => 'required',
		  	'contactform_email' => 'required|email',
			'contactform_subject' => 'required',
			'contactform_phone' => 'required',
			'contactform_message' => 'required',
			'g-recaptcha-response' => 'required|captcha',
		);

		$validator = Validator::make($input, $rules);

		if ($validator->fails()){

		    return Redirect::to(route('contact').'#content')->withInput()->withErrors($validator);
		}
		else {

			$fields = [
				'name' 				=> $input['contactform_name'],
				'email' 			=> $input['contactform_email'],
				'phone' 			=> $input['contactform_phone'],
				'subject' 			=> $input['contactform_subject'],
				'description' 		=> $input['contactform_message'],
				'about' 			=> $input['contactform_service'],
				'status'			=> 1
			];

			// Create new applicants
			Contact::create($fields);

			// Set session flash to user
			Session::flash('flash_message', 'Contact send successfully!');
		}
		// Return to contact page
		return Redirect::to(route('contact'));

	}

}
