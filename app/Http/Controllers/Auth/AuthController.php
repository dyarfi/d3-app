<?php namespace App\Http\Controllers\Auth;

use Request, Auth, Validator;
use Illuminate\Routing\Controller;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\Registrar;
use App\AuthenticateRegisterUsers;
//use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use App\Modules\User\Model\User;


class AuthController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Registration & Login Controller
	|--------------------------------------------------------------------------
	|
	| This controller handles the registration of new users, as well as the
	| authentication of existing users. By default, this controller uses
	| a simple trait to add these behaviors. Why don't you explore it?
	|
	*/
	// Set call for parent trait class
	use AuthenticateRegisterUsers;
	//use AuthenticatesAndRegistersUsers;
	//protected $redirectAfterLogout = 'auth/login';
	//protected $redirectTo = '';

	/**
	 * Create a new authentication controller instance.
	 *
	 * @param  \Illuminate\Contracts\Auth\Guard  $auth
	 * @param  \Illuminate\Contracts\Auth\Registrar  $registrar
	 * @return void
	 */
	public function __construct(Guard $auth, Registrar $registrar)
	{

		$this->auth = $auth;
		$this->registrar = $registrar;

		$this->middleware('guest', ['except' => 'getLogout']);
	}

    /**
     * Validates a user.
     *
     * @param  array  $data
     * @param  mixed  $id
     * @return \Illuminate\Support\MessageBag
     */
    protected function validate($data, $rules)
    {
        $validator = Validator::make((array) $data, $rules);

        $validator->passes();

        return $validator->errors();
    }
    
}
