<?php namespace App\Modules\User\Controller;

// Load Laravel classes
use Route, Request, Session, Redirect, Input, Validator, View;
// Load Sentinel and Socialite classes
use Sentinel, Socialite;
// Load main base controller
use App\Modules\BaseAdmin;
// Load main models
use App\Modules\User\Model\User;
use App\Modules\User\Model\Team;

class Teams extends BaseAdmin {

	/**
	 * Holds the Sentinel Teams repository.
	 *
	 * @var \Cartalyst\Sentinel\Teams\EloquentTeam
	 */
	protected $teams;

	/**
	 * Constructor.
	 *
	 * @return void
	 */
	public function __construct()
	{

		// Parent constructor
		parent::__construct();

		// Load Http/Middleware/Admin controller
		$this->middleware('auth.admin');

		// Load teams and create model from Sentinel
		$this->teams = new Team;

	}

	/**
	 * Display a listing of teams.
	 *
	 * @return \Illuminate\View\View
	 */
	public function index()
	{

		// Set model
		$team = new Team;

		// Set return data
	   	$rows = Input::get('path') === 'trashed' ? Team::onlyTrashed()->paginate(10) : Team::paginate(10);

	   	// Get deleted count
		$deleted = Team::onlyTrashed()->get()->count();

		// Get trashed mode
		$junked  = Input::get('path');

		// Load needed scripts
		$scripts = [
					'library' => asset("themes/ace-admin/js/library.js")
					];

		return $this->view('User::sentinel.teams.index')
		->data(compact('team','rows','deleted','junked'))
		->title('Team Listing');
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
        $team = $this->teams->findOrFail($id);

        // Read ACL settings config for any permission access
        $acl = config('setting.acl');

		// Set data to return
	   	$data = ['row'=>$team,'acl'=>$acl];

	   	// Return data and view
	   	return $this->view('User::sentinel.teams.show')->data($data)->title('View Team');

	}

	/**
	 * Show the form for creating new team.
	 *
	 * @return \Illuminate\View\View
	 */
	public function create()
	{
		return $this->showForm('create');
	}

	/**
	 * Handle posting of the form for creating new team.
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function store()
	{
		return $this->processForm('create');
	}

	/**
	 * Show the form for updating team.
	 *
	 * @param  int  $id
	 * @return mixed
	 */
	public function edit($id)
	{
		return $this->showForm('update', $id);
	}

	/**
	 * Handle posting of the form for updating team.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function update($id)
	{
		return $this->processForm('update', $id);
	}

	/**
	 * Remove the specified team.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function trash($id)
	{
		if ($team = Team::find($id))
		{

			// Add deleted_at and not completely delete
			$team->delete();

			// Redirect with messages
			return Redirect::to(route('admin.teams.index'))->with('success', 'Team Trashed!');
		}

		return Redirect::to(route('admin.teams.index'))->with('error', 'Team Not Found!');;
	}

	/**
	 * Restored the specified setting.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function restored($id)
	{
		if ($team = Team::onlyTrashed()->find($id))
		{

			// Restored back from deleted_at database
			$team->restore();

			// Redirect with messages
			return Redirect::to(route('admin.teams.index'))->with('success', 'Team Restored!');
		}

		return Redirect::to(route('admin.teams.index'))->with('error', 'Team Not Found!');
	}

	/**
	 * Remove the specified team.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function delete($id)
	{
		if ($team = Team::onlyTrashed()->find($id))
		{

			// Completely delete from database
			$team->forceDelete();

			// Redirect with messages
			return Redirect::to(route('admin.teams.index','path=trashed'))->with('success', 'Team Permanently Deleted!');

		}

		return Redirect::to(route('admin.teams.index','path=trashed'))->with('error', 'Team Not Found!');;
	}

	/**
	 * Shows the form.
	 *
	 * @param  string  $mode
	 * @param  int     $id
	 * @return mixed
	 */
	protected function showForm($mode, $id = null)
	{
		if ($id)
		{
			if ( ! $row = $this->teams->find($id))
			{
				return Redirect::to(route('admin.teams.index'));
			}

			$row = Team::find($id);

		}
		else
		{
			//$team = $this->teams;
			$row = $this->teams;
		}

		return $this->view('User::sentinel.teams.form')->data(compact('mode', 'row'))->title('Teams '.$mode);
	}

	/**
	 * Processes the form.
	 *
	 * @param  string  $mode
	 * @param  int     $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	protected function processForm($mode, $id = null)
	{

		$input = Input::all();

		$rules = [
			'name' => 'required|max:32'
		];

		if ($id)
		{

			$team = $this->teams->find($id);

			$messages = $this->validateTeam($input, $rules);

			if ($messages->isEmpty())
			{
				$team->fill($input);

				$team->save();
			}
		}
		else
		{

			$messages = $this->validateTeam($input, $rules);

			if ($messages->isEmpty())
			{

				$team = $this->teams->create($input);

			}
		}

		if ($messages->isEmpty())
		{
			return Redirect::to(route('admin.teams.show', $team->id))->with('success', 'Team Updated!');;
		}

		return Redirect::back()->withInput()->withErrors($messages);
	}

	/**
	 * List invitation.
	 *
	 * @return \Illuminate\Support\MessageBag
	 */
	protected function invitation()
	{
		//$rules = [
			//'email' => 'required|email|max:32'
		//];

		//$validator = Validator::make($data, $rules);

		//$validator->passes();

		$data = ['rows'=>''];
		//return $validator->errors();
		// Return data and view
		return $this->view('User::sentinel.teams.invitation')->data($data)->title('Invitation Team');

	}

	/**
	 * Validates a team.
	 *
	 * @param  array  $data
	 * @param  mixed  $id
	 * @return \Illuminate\Support\MessageBag
	 */
	protected function validateTeam($data, $rules)
	{
		$validator = Validator::make($data, $rules);

		$validator->passes();

		return $validator->errors();
	}

	/**
	 * Send invitation to a team.
	 *
	 * @param  array  $data
	 * @param  mixed  $team_id
	 * @return \Illuminate\Support\MessageBag
	 */
	protected function invite($data, $team_id)
	{
		$rules = [
			'email' => 'required|email|max:32'
		];

		$validator = Validator::make($data, $rules);

		$validator->passes();

		return $validator->errors();
	}

}
