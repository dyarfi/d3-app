<?php namespace App\Http\Controllers\Auth;

use Illuminate\Routing\Controller;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\PasswordBroker;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;

use App\Modules\Page\Model\Menu;
use App\Modules\User\Model\Setting;

use View;

class PasswordController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Password Reset Controller
	|--------------------------------------------------------------------------
	|
	| This controller is responsible for handling password reset requests
	| and uses a simple trait to include this behavior. You're free to
	| explore this trait and override any methods you wish to tweak.
	|
	*/

	use ResetsPasswords;

	/**
	 * Create a new password controller instance.
	 *
	 * @param  \Illuminate\Contracts\Auth\Guard  $auth
	 * @param  \Illuminate\Contracts\Auth\PasswordBroker  $passwords
	 * @return void
	 */
	public function __construct(Guard $auth, PasswordBroker $passwords)
	{
		$this->auth = $auth;
		$this->passwords = $passwords;
  		$this->subject = 'Your Password Reset Link'; //  < --JUST ADD THIS LINE
		$this->middleware('guest');

		View::share('menus', Menu::all());
		View::share('settings', Setting::all());
	}

	public function postEmail(Request $request)
	{
	    $this->validate($request, ['email' => 'required']);

	    $response = $this->passwords->sendResetLink($request->only('email'), function($message)
	    {
	        $message->subject('Password Reminder');
	    });

	    switch ($response)
	    {
	        case PasswordBroker::RESET_LINK_SENT:
	            return redirect()->back()->with('status', trans($response));

	        case PasswordBroker::INVALID_USER:
	            return redirect()->back()->withErrors(['email' => trans($response)]);
	    }
	}
}
