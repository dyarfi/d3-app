<?php namespace App\Modules\Auth;

use App\Http\Controllers\Controller;
//use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
//use Cartalyst\Sentinel\Checkpoints\NotActivatedException;
//use Cartalyst\Sentinel\Checkpoints\ThrottlingException;
//use Cartalyst\Sentinel\Activations;
use Sentinel, Email, Teamwork;

// Load Laravel classes
use Input, View, Validator, Redirect;

class AuthAdminController extends Controller {

	//protected $auth = '';
	protected $setting = '';

	protected $admin_app = '';

	protected $admin_url = '';

	/**
	 * Create a new authentication controller instance.
	 *
	 * @param  \Illuminate\Contracts\Auth\Guard  $auth
	 * @param  \Illuminate\Contracts\Auth\Registrar  $registrar
	 * @return void
	 */
	public function __construct(Sentinel $auth)
	{

		$this->middleware('auth.admin', ['only' => 'getLogin','getLogout','getIndex','getInvitation']);

		$this->setting 		= config('setting');

		$this->admin_app	= $this->setting['admin_app'];

		$this->admin_url	= $this->setting['admin_url'];

	}

	public function index() {

		if( ! Sentinel::check() ) {

			 return Redirect::to(route('admin.login'));

		} else {

			 return Redirect::to(route('admin.dashboard'));

		}

	}

	/**
	 * Show the form for logging the user in.
	 *
	 * @return \Illuminate\View\View
	 */
	public function login()
	{
		return View::make('User::sentinel.login',['title'=>'Login Page']);
	}

	/**
	 * Handle posting of the form for logging the user in.
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function processLogin()
	{
		try
		{
			$input = Input::all();

			$rules = [
				'email'    => 'required|email',
				'password' => 'required',
			];

			$validator = Validator::make($input, $rules);

			if ($validator->fails())
			{
				return Redirect::back()
					->withInput()
					->withErrors($validator);
			}

			$remember = (bool) Input::get('remember', false);

			if (Sentinel::authenticate($input, $remember))
			{
				// Check if previous url is valid
				if ($input['previous_url'] && $input['previous_url'] !== route('admin.noaccess')) {
					// Redirect to previous url
					return Redirect::intended($input['previous_url']);
				} else {
					// Or redirect to dashboard
					return Redirect::intended($this->admin_url.'/dashboard');
				}
			}

			$errors = 'Invalid login or password.';
		}
		catch (NotActivatedException $e)
		{
			$errors = 'Account is not activated!';

			return Redirect::to('reactivate')->with('user', $e->getUser());
		}
		catch (ThrottlingException $e)
		{
			$delay = $e->getDelay();

			$errors = "Your account is blocked for {$delay} second(s).";
		}

		return Redirect::back()
			->withInput()
			->withErrors($errors);
	}

	/**
	 * Show the form for the user registration.
	 *
	 * @return \Illuminate\View\View
	 */
	public function register()
	{
		return View::make('User::sentinel.register');
	}

	/**
	 * Handle team invitation cancel page for the user.
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
   	//public function invitationCancel()
   	//{

		//return View::make('User::sentinel.invitation',['title'=>'Invitation Page']);

   	//}

	/**
	 * Handle team invitation page for the user.
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function invitation($code='', $action='')
	{
		// Set empty messages
		$message	= '';
		// Set default state
		$state 		= false;

		if ($code && $action) {

			if ($action == 'accept') {

				$invite = Teamwork::getInviteFromAcceptToken( $code ); // Returns a TeamworkInvite model or null

				if( $invite ) // valid token found
				{
					// Set new user base on the invitation code
					// $user = new User;
					// $user->email = $invite->email;
					// $user->password = null;
					// $user->save();

					// Set user data array
					$invited['email'] = $invite->email;
					$invited['password'] = 'password';

					// Register account
					Sentinel::registerAndActivate($invited);

					// Delete invitation
					$invite->delete();

					// Set state
					$state = true;
					$message = 'Your account has been created, please continue!';
					// Teamwork::acceptInvite( $invite );

				} else {

					$message = 'Invitation not existed!';

				}

			} elseif ($action == 'deny') {

				$invite = Teamwork::getInviteFromDenyToken( $code ); // Returns a TeamworkInvite model or null

				if( $invite ) // valid token found
				{

					$invite->delete();
					$message = 'Your invitation has been cancel, thank you!';
					// Teamwork::denyInvite( $invite );

				} else {

					$message = 'Invitation not existed anymore!';

				}
			}

		} else {

			return Redirect::back()->with('error','No other action included!');

		}

		return View::make('User::sentinel.invitation',['title'=>'Invitation Page','message'=>$message])->with($message);
	}

	/**
	 * Handle posting of the form for the user registration.
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function processRegistration()
	{
		$input = Input::all();

		$rules = [
			'email'            => 'required|email|unique:users',
			'password'         => 'required',
			'password_confirm' => 'required|same:password',
		];

		$validator = Validator::make($input, $rules);

		if ($validator->fails())
		{
			return Redirect::back()
				->withInput()
				->withErrors($validator);
		}

		if ($user = Sentinel::register($input))
		{
			$activation = Activation::create($user);

			$code = $activation->code;

			$sent = Mail::send('User::sentinel.emails.activate', compact('user', 'code'), function($m) use ($user)
			{
				$m->to($user->email)->subject('Activate Your Account');
			});

			if ($sent === 0)
			{
				return Redirect::to('register')
					->withErrors('Failed to send activation email.');
			}

			return Redirect::to('login')
				->withSuccess('Your accout was successfully created. You might login now.')
				->with('userId', $user->getUserId());
		}

		return Redirect::to('register')
			->withInput()
			->withErrors('Failed to register.');
	}

	/**
	 * Show the login form after logout redirect response.
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function logout() {

        // Sentinel Logout
        Sentinel::logout();

        // Redirect to Admin Panel
        return Redirect::to(route('admin.login'));

	}

}
