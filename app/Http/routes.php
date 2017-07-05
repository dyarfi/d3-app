<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

//Route::get('/', 'WelcomeController@index');
//Route::get('home', 'HomeController@index');

// Front routes endpoint for home page
Route::get('/', [
    'as' => 'home',
    'uses' => 'HomeController@index'
]);

Route::get('page', [
    'as' => 'page',
    'uses' => 'PagesController@index'
]);

// Public User routes ...
//Route::get('user', 'UsersController@index');
//Route::post('user/edit', 'UsersController@edit');
//Route::get('user', 'UsersController@profile');
//Route::get('profile', 'UsersController');
//Route::get('profile/update', 'UsersController@update');

//Route::get('profile', array('as' => 'profile', 'uses' => 'UsersController'));
//Route::get('profile', array('as' => 'profile', 'uses' => 'UsersController@showProfile'));

//Route::get('profile/edit', 'UsersController@edit');

//Route::controllers([
    //'auth' => 'App\Modules\Auth\AuthController',
    //'password' => 'App\Modules\Auth\PasswordController',
//]);

//Route::get('auth/social',

// Front routes endpoint resources
//Route::resource('tasks', 'TasksController');
//Route::resource('users', 'UsersController');

// Disable checkpoints (throttling, activation) for demo purposes
Sentinel::disableCheckpoints();

/* **************************************
 *
 * Load Administrator config setting
 *
 * **************************************
 */

// Load config/setting.php file
$setting = config('setting');

// Share a var with all views : $admin_url
View::share('admin_url', $setting['admin_url']);

// Share a var with all views : $admin_url
View::share('admin_app', $setting['admin_app']);

// Share a var with all views : $admin_url
View::share('company_name', $setting['company_name']);

/*** Site Menus ***/
// About Us page routes...
Route::get('about_us', ['as'=>'about_us','uses'=>'AboutUsController@index']);
// Service page routes...
Route::get('services', ['as'=>'services','uses'=>'ServicesController@index']);
// Portfolio page routes...
Route::get('portfolio', ['as'=>'portfolio','uses'=>'PortfolioController@index']);
Route::get('portfolio/{slug}', ['as'=>'portfolio.show','uses'=>'PortfolioController@show']);
// Blog page routes...
Route::get('blog/tag/{slug}', ['as'=>'blog.tag','uses'=>'BlogController@tag']);
Route::get('blog', ['as'=>'blog','uses'=>'BlogController@index']);
Route::get('blog/{slug}', ['as'=>'blog.show','uses'=>'BlogController@show']);
// Career page routes...
Route::get('career', ['as'=>'career','uses'=>'CareerController@index']);
Route::post('career/post', ['as'=>'career.post','uses'=>'CareerController@post']);
Route::get('career', ['as'=>'career','uses'=>'CareerController@index']);
Route::post('career/post', ['as'=>'career.post','uses'=>'CareerController@post']);
Route::get('career/{slug}', ['as'=>'career.show','uses'=>'CareerController@show']);
Route::get('career/detail/{slug}', ['as'=>'career.detail','uses'=>'CareerController@detail']);
Route::get('career/{slug}/apply', ['as'=>'career.apply','uses'=>'CareerController@apply']);
Route::post('career/{slug}/apply', ['as'=>'career.apply','uses'=>'CareerController@store']);
// Gallery page routes...
Route::get('gallery', ['as'=>'gallery','uses'=>'GalleryController@index']);
Route::get('gallery/upload', ['as'=>'gallery.upload','uses'=>'GalleryController@upload']);
Route::post('gallery/response', ['as'=>'gallery.response','uses'=>'GalleryController@response']);
Route::get('gallery/response', ['as'=>'gallery.response','uses'=>'GalleryController@response']);
// Contact page routes...
Route::get('contact', ['as'=>'contact','uses'=>'ContactController@index']);
Route::post('contact', ['as'=>'contact.send','uses'=>'ContactController@sendContact']);

//Route::get('gallery/{slug}', ['as'=>'gallery.show','uses'=>'GalleryController@show']);
//Route::get('gallery/{slug}/make', ['as'=>'gallery.make','uses'=>'GalleryController@make']);

// User related routes...
Route::get('profile',['as'=>'profile','uses'=>'UsersController@profile']);
Route::get('profile/{id}', ['as'=>'profile.edit', 'uses'=>'UsersController@edit']);
Route::patch('profile/{id}', ['as'=>'profile.update', 'uses'=>'UsersController@update']);
// Route::get('auth/profile', 'Auth\AuthSocialController@profile');
// Route::get('auth/logout', 'Auth\AuthSocialController@logout');
// Sentinel Routes...
Route::get('auth/social/{provider}', 'Auth\AuthSocialController@redirectToProvider');
Route::get('auth/social', 'Auth\AuthSocialController@handleProviderCallback');
// Authentication routes...
Route::get('auth/login', ['as'=>'login','uses'=>'Auth\AuthController@getLogin']);
Route::post('auth/login', ['as'=>'login.post','uses'=>'Auth\AuthController@postLogin']);
Route::get('auth/logout', ['as'=>'logout','uses'=>'Auth\AuthController@getLogout']);
// Password forgotten routes...
Route::get('auth/password/email','Auth\PasswordController@getEmail');
Route::post('auth/password/email','Auth\PasswordController@postEmail');
//Route::post('auth/register', 'Auth\AuthController@postRegister');
// Registration routes...
Route::get('register', ['as'=>'register','uses'=>'Auth\AuthController@getRegister']);
Route::post('register', ['as'=>'register.post','uses'=>'Auth\AuthController@postRegister']);

/*
// Display all SQL executed in Eloquent
Event::listen('illuminate.query', function($query)
{
    var_dump($query);
});
*/

// ******************* Admin Routes ********************* } //


/*
Route::group(['prefix' => 'apanel/roles'], function()
{
    Route::get('/', 'Admin\RolesController@index');
    Route::get('create', 'Admin\RolesController@create');
    Route::post('create', 'Admin\RolesController@store');
    Route::get('{id}', 'Admin\RolesController@edit');
    Route::post('{id}', 'Admin\RolesController@update');
    Route::get('{id}/delete', 'Admin\RolesController@delete');
});
*/

//Route::get('login/{provider}', 'Auth\AuthController@login');

//Route::resource('auth', 'AuthController');

Route::get('wait', function()
{
    return View::make('User::sentinel.wait');
});

Route::get('activate/{id}/{code}', function($id, $code)
{
    $user = Sentinel::findById($id);

    if ( ! Activation::complete($user, $code))
    {
        return Redirect::to("login")
            ->withErrors('Invalid or expired activation code.');
    }

    return Redirect::to('login')
        ->withSuccess('Account activated.');
})->where('id', '\d+');

Route::get('reactivate', function()
{
    if ( ! $user = Sentinel::check())
    {
        return Redirect::to('login');
    }

    $activation = Activation::exists($user) ?: Activation::create($user);

    // This is used for the demo, usually you would want
    // to activate the account through the link you
    // receive in the activation email
    Activation::complete($user, $activation->code);

    // $code = $activation->code;

    // $sent = Mail::send('sentinel.emails.activate', compact('user', 'code'), function($m) use ($user)
    // {
    //  $m->to($user->email)->subject('Activate Your Account');
    // });

    // if ($sent === 0)
    // {
    //  return Redirect::to('register')
    //      ->withErrors('Failed to send activation email.');
    // }

    return Redirect::to('account')
        ->withSuccess('Account activated.');
})->where('id', '\d+');

Route::get('deactivate', function()
{
    $user = Sentinel::check();

    Activation::remove($user);

    return Redirect::back()
        ->withSuccess('Account deactivated.');
});

Route::get('reset', function()
{
    if(Sentinel::check()) {
        return Redirect::to(route('admin.dashboard'));
    }

    return View::make('User::sentinel.reset.begin');
});

Route::post('reset', function()
{
    $rules = [
        'email' => 'required|email',
    ];

    $validator = Validator::make(Input::get(), $rules);

    if ($validator->fails())
    {
        return Redirect::back()
            ->withInput()
            ->withErrors($validator);
    }

    $email = Input::get('email');

    $user = Sentinel::findByCredentials(compact('email'));

    if ( ! $user)
    {
        return Redirect::back()
            ->withInput()
            ->withErrors('No user with that email address belongs in our system.');
    }

    $reminder = Reminder::exists($user) ?: Reminder::create($user);

    $code = $reminder->code;

    $sent = Mail::send('User::sentinel.emails.reminder', compact('user', 'code'), function($m) use ($user)
    {
     $m->to($user->email)->subject('Reset your account password.');
    });

    if ($sent === 0)
    {
     return Redirect::to('register')
         ->withErrors('Failed to send reset password email.');
    }

    return Redirect::to('wait');
});

Route::get('reset/{id}/{code}', function($id, $code)
{
    if(Sentinel::check()) {
        return Redirect::to(route('admin.dashboard'));
    }

    $user = Sentinel::findById($id);

    return View::make('User::sentinel.reset.complete');

})->where('id', '\d+');

Route::post('reset/{id}/{code}', function($id, $code)
{
    $rules = [
        'password' => 'required|confirmed',
    ];

    $validator = Validator::make(Input::get(), $rules);

    if ($validator->fails())
    {
        return Redirect::back()
            ->withInput()
            ->withErrors($validator);
    }

    $user = Sentinel::findById($id);

    if ( ! $user)
    {
        return Redirect::back()
            ->withInput()
            ->withErrors('The user no longer exists.');
    }

    if ( ! Reminder::complete($user, $code, Input::get('password')))
    {
        return Redirect::to(route('admin.login'))
            ->withErrors('Invalid or expired reset code.');
    }

    return Redirect::to(route('admin.login'))
        ->withSuccess("Password Reset.");

})->where('id', '\d+');

Route::group(['prefix' => 'account', 'before' => 'auth'], function()
{

    Route::get('/', function()
    {
        $user = Sentinel::getUser();

        $persistence = Sentinel::getPersistenceRepository();

        return View::make('User::sentinel.account.home', compact('user', 'persistence'));
    });

    Route::get('kill', function()
    {
        $user = Sentinel::getUser();

        Sentinel::getPersistenceRepository()->flush($user);

        return Redirect::back();
    });

    Route::get('kill-all', function()
    {
        $user = Sentinel::getUser();

        Sentinel::getPersistenceRepository()->flush($user, false);

        return Redirect::back();
    });

    Route::get('kill/{code}', function($code)
    {
        Sentinel::getPersistenceRepository()->remove($code);

        return Redirect::back();
    });

});



//Route::get('profile', 'UsersController@profile');
/*
Route::get('users/edit/{id}', [
    'as' => 'users.edit', 'uses' => 'UsersController@edit'
]);
Route::get('users/show/{id}', [
    'as' => 'users.show', 'uses' => 'UsersController@show'
]);
Route::get('users', [
    'as' => 'users.index', 'uses' => 'UsersController@index'
]);
Route::get('users/create', [
    'as' => 'users.create', 'uses' => 'UsersController@create'
]);
Route::get('users/destroy', [
    'as' => 'users.destroy', 'uses' => 'UsersController@destroy'
]);
Route::get('profile', [
    'as' => 'profile', 'uses' => 'UsersController@profile'
]);
Route::get('profile/update', [
    'as' => 'profile.update', 'uses' => 'UsersController@update'
]);
*/
