<?php namespace App\Http\Controllers;

// Load Laravel classes
use Route, Request, Input, Validator, Redirect, Session;

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

		// Set data to return
	   	$data = ['menu'=>$this->menu->where('slug', $path)->first(),'contact'=>$this->contact];

	   	// Return data and view
	   	return $this->view('contacts.form')->data($data)->title('Contact - Laravel Contacts');
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
		  	'name' => 'required',
		  	'email' => 'required|email',
			'subject' => 'required',
			'g-recaptcha-response' => 'required|captcha',
			'description' => 'required',
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
