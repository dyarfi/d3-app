<?php namespace App\Http\Controllers;

// Load Laravel classes
use Request, Input, Validator, Redirect, Session, Mail;

// Load main models
// Apps Contact model
use App\Modules\Contact\Model\Contact;
// Apps Setting model
use App\Modules\User\Model\Setting;

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

		// Social media icons
		$socials = Setting::where('group','socmed')->where('status',1)->get(['name','key','value']);

		// Company data
		$company = Setting::where('group','company')->where('status',1)->get(['name','key','description','value']);

		// Set data to return
	   	$data = ['menu'=>$this->menu->where('slug', $path)->first(),'contact'=>$this->contact,'socials'=>$socials,'company'=>$company];

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

			// Sent thank you email to public
		    $sent_public = Mail::send('emails.contact_public', $fields, function($e) use ($fields)
			    {
			     	$e->to($fields['email'])->subject('Contact Message | ' . url());
			    }
			);

			// Setup for website administrator email data
			$admin = Setting::where('group','email')->where('key','contact')->firstOrFail();

			// Set email admin view variables
			$fields['admin_name'] = $admin->name;
			$fields['admin_email'] = $admin->value;

			// Sent thank you email to admin
		    $sent_admin = Mail::send('emails.contact_admin', $fields, function($ea) use ($fields)
			    {
					$ea->to($fields['admin_email'])->subject('Contact Message From ' . $fields['name']);
			    }
			);

			// Send message if failed
		    if ($sent_public === 0 && $sent_admin === 0)
		    {
		     	return Redirect::to('contact')->withErrors('Failed to send email message.');
		    }

			// Create new applicants
			Contact::create($fields);

			// Set session flash to user
			Session::flash('flash_message', 'Contact send successfully!');
		}
		// Return to contact page
		return Redirect::to(route('contact'));

	}

}
