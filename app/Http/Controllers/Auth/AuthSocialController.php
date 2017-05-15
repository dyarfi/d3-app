<?php namespace App\Http\Controllers\Auth;

use Illuminate\Routing\Controller;
use Illuminate\Contracts\Auth\Guard;
use Input, Auth, Sentinel, Socialite;
use App\Modules\User\Model\User;

class AuthSocialController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Guard $auth)
    {

        $this->auth = $auth;

    }

    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return Response
     */
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return Response
     */
    public function handleProviderCallback()
    {

        /*
        $user = Socialite::driver( $provider )->user();
        $code = Input::get('code');
        //if(!$code)
            //return redirect()->route('auth.login')
                //->with('status', 'danger')
                //->with('message', 'You did not share your profile data with our socail app.');
        //if(!$user->email)
        //{
            //return redirect()->route('auth.login')
                //->with('status', 'danger')
                //->with('message', 'You did not share your email with our social app. You need to visit App Settings and remove our app, than you can come back here and login again. Or you can create new account.');
        //}

        $socialUser = null;

        //Check is this email present
        $userCheck = User::where('email', '=', $user->email)->first();

        if(!empty($userCheck))
        {
            $socialUser = $userCheck;
        }
        else
        {
            $sameSocialId = Social::where('social_id', '=', $user->id)->where('provider', '=', $provider )->first();
            if(empty($sameSocialId))
            {
                //There is no combination of this social id and provider, so create new one
                $newSocialUser = new User;
                $newSocialUser->email              = $user->email;
                $name = explode(' ', $user->name);
                $newSocialUser->first_name         = $name[0];
                $newSocialUser->last_name          = $name[1];
                $newSocialUser->save();
                $socialData = new Social;
                $socialData->social_id = $user->id;
                $socialData->provider= $provider;
                $newSocialUser->social()->save($socialData);
                // Add role
                $role = Role::whereName('user')->first();
                $newSocialUser->assignRole($role);
                $socialUser = $newSocialUser;
            }
            else
            {
                //Load this existing social user
                $socialUser = $sameSocialId->user;
            }
        }
        $this->auth->login($socialUser, true);
        if( $this->auth->user()->hasRole('user'))
        {
            return redirect()->route('user.home');
        }
        if( $this->auth->user()->hasRole('administrator'))
        {
            return redirect()->route('admin.home');
        }
        return \App::abort(500);
        */

        $provider  = Input::get('provider');
        
        $socialite = Socialite::driver($provider)->user();

        $userDb    = User::where('provider_id', $socialite->id)->first();

        // Set default email
        $email = ($socialite->email) ? $socialite->email : '-';

        // Set default password
        $password = ($userDb->password) ? $userDb->password : $socialite->id;

        // Set default user social data
        $userData = [
                    'provider_id'   => $socialite->id,
                    'provider'      => $provider,
                    //'name' => $socialite->name,
                    'username'      => $socialite->nickname,
                    'avatar'        => $socialite->avatar,
                ];

        $credentials = [
            'email'    => $email,
            'password' => $socialite->id,
        ];

        if (!$userDb) {

            $user = Sentinel::registerAndActivate($credentials);

            $userUpdate = User::where('id', $user->id)->update($userData);

            $userLogged = Sentinel::findById($user->id);

        }

        $userLogin  = $this->auth->attempt($credentials, true);

        return redirect()->intended('career');
    }

    /**
     * Obtain the user information from Database.
     *
     * @return Response
     */
    public function profile()
    {
        dd(Auth::user());
    }
    /**
     * Logout user social login.
     *
     * @return Response
     */
    public function logout()
    {
        Auth::logout();
        return redirect()->intended();
    }

}
