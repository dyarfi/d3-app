<?php namespace App\Modules\User\Controller;

// Load Laravel classes
use Route, Session, Redirect, Input, Validator, View, Mail;
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
	   	$rows = Input::get('path') === 'trashed' ? Team::with('owner')->onlyTrashed()->paginate(10) : Team::with('owner')->paginate(10);

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
        $team = $this->teams->with('owner')->findOrFail($id);

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

			// Get data
			$team = $this->teams->find($id);
			// Set validation messages
			$messages = $this->validateTeam($input, $rules);

			if ($messages->isEmpty())
			{
				// Update data
				$team->fill($input);
				$team->save();

			}
		}
		else
		{

			//$input['owner_id'] = $this->user->id;

			$messages = $this->validateTeam($input, $rules);

			if ($messages->isEmpty())
			{

				//$team = $this->teams->create($input);
				$team	= new Team();
				$team->owner_id = $this->user->id;
				$team->name = $input['name'];
				$team->save();

			}
		}

		if ($messages->isEmpty())
		{
			return Redirect::to(route('admin.teams.show', $team->id))->with('success', 'Team Updated!');;
		}

		return Redirect::back()->withInput()->withErrors($messages);
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
	 * List invitation.
	 *
	 * @return \Illuminate\Support\MessageBag
	 */
	protected function invitation()
	{
 		// Set data to view
		$data = ['teams'=>Team::all()->lists('name','id')];

		// Set inline script or style
		$inlines = [
			// Script execution on a specific controller page
			'script' => "
			// --- form team invitation submit handler [".route('admin.teams.invitation')."]--- //
				var forminvite  = $('#form-team-invite');
				forminvite.submit(function() {
					if(forminvite.find('select[name=team_id]').val() != ''
						&& forminvite.find('input[name=email]').val() != '') {
							$(this).before('<div class=\"dataTables_processing\">&nbsp;</div>');
							return true;
					} else {
						var label = $(this).find('label');
						var text = label.html();
						label.next('span.red').remove();
						label.after('<span class=\"red\"> * required</span>');
						return false;
					}
				});
			",
		];

		// Return data and view
		return $this->view('User::sentinel.teams.invitation')->data($data)->inlines($inlines)->title('Invitation Team');

	}

	/**
	 * Send invitation to a team.
	 *
	 * @param  array  $request
	 * @param  mixed  $team_id
	 * @return \Illuminate\Support\MessageBag
	 */
	protected function invite()
	{

		// Filter input all
		$input = array_filter(Input::all());

		// How we should define our validator rule
		$validator = Validator::make($input, [
			'team_id' => 'required',
		    'email' => 'required|regex:/^([_a-z0-9\-]+)(\.[_a-z0-9\-]+)*@([a-z0-9\-]{2,}\.)*([a-z]{2,4})(,\s([_a-z0-9\-]+)(\.[_a-z0-9\-]+)*@([a-z0-9\-]{2,}\.)*([a-z]{2,4}))*$/
',
		]);

	   	// Set messages
	   	$messages = $validator->errors();

		// Set default state
		$state = false;

		// If Passes check the email in the database
		if ($messages->isEmpty())
		{
			// Explode email having the separator (, )
			$emails = explode(', ', $input['email']);

			// Check if the emails is an array
			if (is_array($emails)) {
				// Set default existed
				$existed = '';
				// Check in the loop
				foreach ($emails as $email) {
					// Check if email existed in the database
					$count = User::where('email','=',$email)->count();
					// if existed
					if ($count) {
						// Set emails with count
						$existed[$email] = $count;
					} else {
						// We can continue the process
						$state = true;
					}
				}

				// If not existed in database and state is true
				if (!$existed && $state) {

					// Send email invitation and save to database
					$team = Team::find($input['team_id']);
					$user = $this->user;

					// Loop for mass mailing and insert invitation to database
					foreach ($emails as $email) {
						// Set invitation models
						$invite               = app()->make(config('teamwork.invite_model'));
						$invite->user_id      = $user->id;
						// Set model data
						$invite->team_id      = $team->id;
						$invite->type         = 'invite';
						$invite->email        = $email;
						$invite->accept_token = md5( uniqid( microtime() ) );
						$invite->deny_token   = md5( uniqid( microtime() ) );

						// Send email to user / let them know that they got invited
						$sent = Mail::send('User::sentinel.emails.invitation', compact('invite', 'user', 'team'), function($m) use ($email) {
							// Send to and subject
					 		$m->to($email)->subject('Team Invitation');
						});

						// Save Model
						$invite->save();
					}

					if ($sent === 0)
					{
					 return Redirect::to(route('admin.teams.invitation'))
						 ->withErrors('Failed to send invitation email.');
					}

					// Redirect to default page
					return Redirect::to(route('admin.teams.invitation'))->with('success', 'Team Invited!');

				} else {

					// Set email error messages
					$messages = ['email' => 'Email existed : '. implode(", ", array_keys($existed))];

				}

			}

		}

		return Redirect::back()->withInput()->withErrors($messages);
	}

}
