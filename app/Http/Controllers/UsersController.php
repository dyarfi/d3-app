<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Modules\User\Model\User;
use Auth;
use Route;
use Session;

// use GuzzleHttp\Exception\GuzzleException;
// use GuzzleHttp\Client;
// use GuzzleHttp\HandlerStack;
// use GuzzleHttp\Subscriber\Oauth\Oauth1;

use App\Tweet;
//use Socialite;

class UsersController extends BasePublic {

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct(){
		parent::__construct();

		$this->middleware('auth');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index() {

		// Set return data
	   	$users = User::paginate(2);

	   	// Set pagination path
	   	//$tasks->setPath('users');

	   	// Set data to return
	   	$data = ['users'=>$users];

	   	// Return data and view
	   	return $this->view('users.index')->data($data)->title('User List - Laravel Users');
	}

	/**
	 * Display user dashboard of the website.
	 *
	 * @return Response
	 */
	public function dashboard() {

	 	if (Auth::check()) {
	        $tweets = Tweet::orderBy('created_at','desc')->paginate(5);
	    } else {
	        $tweets = Tweet::where('approved',1)->orderBy('created_at','desc')->take(5)->get();
	    }

		// Set return data
	   	$user = Auth::user();

	   	// Set data to return
	   	$data = ['user'=>$user,'tweets' => $tweets];

	   	// Set different layout in the template
	   	$this->layout = 'layouts.app';

	   	// Return data and view
	   	return $this->view('users.profile')->data($data)->title('User Profile - Laravel Users');
	}

	/**
	 * Display user profile of the resource.
	 *
	 * @return Response
	 */
	public function profile() {

		// Set return data
	   	$user = Auth::user();

	   	// Set data to return
	   	$data = ['user'=>$user];

	   	// Return data and view
	   	return $this->view('users.profile')->data($data)->title('User Profile - Laravel Users');
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		// Route::current()->uri()

		// Return view
		return $this->view('users.create')->title('Create Users - Laravel Users');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
		// Validate post data
		$this->validate($request, [
	        'username' => 'required',
	        'about' => 'required'
	    ]);

	    $input = $request->all();

	    User::create($input);

	    Session::flash('flash_message', 'User successfully added!');

	    return redirect()->back();
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		// Get data from database
        $user = User::findOrFail($id);

		// Set data to return
	   	$data = ['user'=>$user];

	   	// Return data and view
	   	return $this->view('users.show')->data($data)->title('View User - Laravel Tasks');

	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$User = User::findOrFail($id);

	    return view('users.edit')->withUser($User);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, Request $request)
	{
	    $User = User::findOrFail($id);

	    $this->validate($request, [
	        'username' => 'required',
	        'about' => 'required'
	    ]);

	    $input = $request->all();

	    $User->fill($input)->save();

	    Session::flash('flash_message', 'User successfully update!');

	    return redirect()->back();
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
	    $User = User::findOrFail($id);

	    $User->delete();

	    Session::flash('flash_message', 'User successfully deleted!');

	    return redirect()->route('Users.index');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function searchBoard($id, $setup)
	{
	    


	    //$User = User::findOrFail($id);

	    //$User->delete();

	    //Session::flash('flash_message', 'User successfully deleted!');

	    //return redirect()->route('Users.index');
	}

}
